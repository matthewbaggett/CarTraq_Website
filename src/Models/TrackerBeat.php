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
 * @var $latitude DECIMAL(
 */
class TrackerBeat extends ActiveRecord
{
    protected $_table = "tracker_beats";

    public $beat_id;
    public $tracker_id;
    public $created;
    public $latitude;
    public $longitude;
    public $speed;
    public $blob;
}
