<?php

use App\Customer;
use App\Helper;
use App\Item;
use App\Order;
use App\OrderStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/***
 * Class MysterionSeeder
 * Imports a json made from the original database
 */
class MysterionSeeder extends Seeder
{
    public function run()
    {
        $json = Storage::disk('www')->get('mysterion_corona.json');
        $json = json_decode($json, true);
        foreach ($json as $entry) {
            if ($entry['type'] !== 'table') {
                continue;
            }

            if ($entry['name'] === 'maker') {
                $this->import_helpers($entry['data']);
            } elseif ($entry['name'] === 'asker') {
                $this->import_askers($entry['data']);
            } elseif ($entry['name'] === 'production') {
                $this->import_production($entry['data']);
            }
        }
    }

    private function import_helpers(array $data)
    {
        $map = [
            'id' => 'id',
            'login' => 'name',
            'name' => 'display_name',
            'street' => 'street',
            'number' => 'number',
            'zip' => 'zip',
            'city' => 'city',
            'phone' => 'phone',
            'cellphone' => 'mobile'
        ];

        $max_id = 0;

        foreach ($data as $row) {
            if (empty($row['login']) || empty($row['name'])) {
                continue;
            }

            $helper = new Helper();
            $max_id = max($max_id, (int)$row['id']);

            $this->_map($map, $row, $helper);
            $helper->country_id = $row['country'] === 'Belgie' ? 1 : 2;
            if (empty($helper->zip)) {
                $helper->zip = '[onbekend]';
            }
            if (empty($helper->city)) {
                $helper->city = '[onbekend]';
            }

            $helper->save();
        }

        $max_id++;
        \Illuminate\Support\Facades\DB::update("ALTER TABLE helpers AUTO_INCREMENT = $max_id;");
    }

    private function _map($map, $source, $target)
    {
        foreach ($map as $source_attribute => $target_attribute) {
            if (!empty($source[$source_attribute])) {
                $target->__set($target_attribute, $source[$source_attribute]);
            }
        }
    }

    /**
     * Askers in the "new site" are a customer and an order
     * @param array $data
     */
    private function import_askers(array $data)
    {
        $customer_map = [
            'id' => 'id',
            'type' => 'sector',
            'name' => 'name',
            'street' => 'street',
            'number' => 'number',
            'zip' => 'zip',
            'email' => 'email',
            'city' => 'city',
            'phone' => 'phone',
            'cellphone' => 'mobile',
        ];

        $order_map = [
            'tav' => 'for',
            'link' => 'identifier',
            'number_requested' => 'quantity',
        ];

        $items = Item::all()->keyBy('type');

        $max_id = 0;
        foreach ($data as $row) {

            $customer = new Customer();
            $max_id = max($max_id, (int)$row['id']);

            $this->_map($customer_map, $row, $customer);
            $customer->country_id = $row['country'] === 'Nederland' ? 2 : 1;
            if (empty($customer->name)) {
                // Can't throw away customers at this point so allow empty names on import
                $customer->name = '[onbekend]';
            }
            if (empty($customer->zip)) {
                // Can't throw away customers at this point so allow empty zip code on import
                $customer->zip = '[onbekend]';
            }
            $customer->save();

            $order = new Order();
            $this->_map($order_map, $row, $order);
            if (empty($order->quantity)) {
                // Can't throw away orders at this point so allow empty zip code on import
                $order->quantity = 0;
            }

            $order->item()->associate($items[$row['type_requested']]);
            $order->customer()->associate($customer);

            // link is the timestamp
            $time = \Carbon\Carbon::createFromFormat('U', $row['link'], config('app.timezone'));
            $order->created_at = $time;

            $order->save(['timestamps' => false]);

            // Add new status
            $status = $order->newStatus();
            $status->type = 'status';
            $status->status_id = 0;
            $status->created_at= $time;
            $status->save(['timestamps' => false]);
        }

        $max_id++;
        \Illuminate\Support\Facades\DB::update("ALTER TABLE customers AUTO_INCREMENT = $max_id;");
    }

    public function import_production(array $data)
    {
        foreach ($data as $row) {
            /** @var Order $order */
            $order = Order::whereCustomerId($row['asker_id'])->first();
            if (!$order) {
                echo 'No order found for row: ', json_encode($row), "\n";
                continue;
            }

            /** @var Helper $helper */
            $helper = Helper::whereId($row['maker_id'])->first();
            if (!$order) {
                echo 'No order found for row: ', json_encode($row), "\n";
                continue;
            }

            try {
                $order->helper()->associate($helper);
                // Accepted order
                $timestamp = $row['accepted'];
                $order->created_at = $this->_status($order, 1, $row['accepted'])->created_at;

                if (!empty($row['started'])) {
                    $this->_status($order, 2, $timestamp = $row['started']);
                }

                if (!empty($row['delivery_time'])) {
                    $this->_status($order, 3, $timestamp = $row['delivery_time']);
                    $this->_production($order, $row['delivery_time']);
                }

                if (!empty($row['delivered'])) {
                    $this->_status($order, 4, $timestamp = $row['delivered']);
                }

                if (!empty($row['comment_maker'])) {
                    $status = $this->_make_status($order, $timestamp);
                    $status->type = 'comment';
                    $status->comment = $row['comment_maker'];
                    $status->saveOrFail(['timestamps' => false]);
                }

                if (!empty($row['comment_asker'])) {
                    $status = $this->_make_status($order, $timestamp, true, false);
                    $status->type = 'comment';
                    $status->comment = $row['comment_asker'];
                    $status->saveOrFail(['timestamps' => false]);
                }
                $order->updated_at = \Carbon\Carbon::createFromFormat('YmdHi', $timestamp, config('app.timezone'));
                $order->save(['timestamps' => false]);
            } catch (Exception $e) {
                echo "Failed on row: ", json_encode($row), "\n";
                throw($e);
            }
        }
    }

    private function _make_status(Order $order, $timestamp, $customer = false, $helper = true): OrderStatus
    {
        $order_status = $order->newStatus($customer, $helper);
        $order_status->created_at = \Carbon\Carbon::createFromFormat('YmdHi', $timestamp, config('app.timezone'));
        return $order_status;
    }

    private function _status($order, $status, $timestamp)
    {
        $order_status = $this->_make_status($order, $timestamp);
        $order->status_id = $status;
        $order_status->type = 'status';
        $order_status->status_id = $status;
        $order_status->saveOrFail(['timestamps' => false]);
        return $order_status;
    }

    private function _production($order, $timestamp)
    {
        $order_status = $this->_make_status($order, $timestamp);
        $order_status->type = 'quantity';
        $order_status->quantity = $order->quantity;
        $order_status->saveOrFail(['timestamps' => false]);
        return $order_status;
    }
}
