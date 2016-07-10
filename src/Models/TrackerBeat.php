<?php
namespace CarTraq\Models;

use Thru\ActiveRecord\ActiveRecord;
use TigerKit\Models;
/**
 * Class TrackerBeat
 * @package TigerKit\Models
 * @var $beat_id INTEGER
 * @var $tracker_id INTEGER
 * @var $created DATE
 * @var $latitude DECIMAL(15,11)
 * @var $longitude DECIMAL(15,11)
 * @var $speed DECIMAL(10,3)
 * @var $blob BLOB
 */
class TrackerBeat extends ActiveRecord
{
    protected $_table = "tracker_beats";

    public $beat_id;
    public $tracker_id;
    public $created;
    public $latitude = 0;
    public $longitude = 0;
    public $speed = 0;
    public $blob = '';
}
