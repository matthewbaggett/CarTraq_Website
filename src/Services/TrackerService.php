<?php

namespace CarTraq\Services;

use CarTraq\Models\Tracker;
use CarTraq\Models\TrackerBeat;

class TrackerService extends Service{

    public function findTrackerByHardwareId($hardware_id){
        $tracker = Tracker::search()->where('hardware_id', $hardware_id)->execOne();
        if(!$tracker){
            $tracker = new Tracker();
            $tracker->hardware_id = $hardware_id;
            $tracker->first_seen = date("Y-m-d H:i:s");
        }
        $tracker->last_seen = date("Y-m-d H:i:s");
        $tracker->save();
        return $tracker;
    }

    public function beat(Tracker $tracker){
        $beat = new TrackerBeat();
        $beat->created = date("Y-m-d H:i:s");
        $beat->tracker_id = $tracker->tracker_id;
        $beat->save();
        return $beat;
    }
}