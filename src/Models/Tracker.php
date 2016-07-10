<?php
namespace CarTraq\Models;

use Thru\ActiveRecord\ActiveRecord;
use TigerKit\Models;
/**
 * Class Tracker
 * @package TigerKit\Models
 * @var $tracker_id INTEGER
 * @var $hardware_id VARCHAR(255)
 * @var $user_id INTEGER
 * @var $first_seen DATE
 * @var $last_seen DATE
 */
class Tracker extends ActiveRecord
{
    protected $_table = "trackers";

    public $tracker_id;
    public $hardware_id;
    public $user_id;
    public $first_seen;
    public $last_seen;
}
