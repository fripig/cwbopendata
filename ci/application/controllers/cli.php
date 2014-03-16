<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cli extends CI_Controller {
    public function get_data()
    {
        $this->_get_one_data('36hr',"MFC/F-C0032-001.xml");
        $this->_get_one_data('week',"MFC/F-C0032-003.xml");
        $this->_get_one_data('cityweek',"MFC/F-C0032-005.xml");
        $this->_get_WeatherAssistant();
    }
    public function _get_WeatherAssistant()
    {
        $locationlist= array(
        "009" => "台北市天氣小幫手",
        "010" => "新北市天氣小幫手",
        "011" => "基隆市天氣小幫手",
        "012" => "花蓮縣天氣小幫手",
        "013" => "宜蘭縣天氣小幫手",
        "014" => "金門縣天氣小幫手",
        "015" => "澎湖縣天氣小幫手",
        "016" => "台南市天氣小幫手",
        "017" => "高雄市天氣小幫手",
        "018" => "嘉義縣天氣小幫手",
        "019" => "嘉義市天氣小幫手",
        "020" => "苗栗縣天氣小幫手",
        "021" => "台中市天氣小幫手",
        "022" => "桃園縣天氣小幫手",
        "023" => "新竹縣天氣小幫手",
        "024" => "新竹市天氣小幫手",
        "025" => "屏東縣天氣小幫手",
        "026" => "南投縣天氣小幫手",
        "027" => "台東縣天氣小幫手",
        "028" => "彰化縣天氣小幫手",
        "029" => "雲林縣天氣小幫手",
        "030" => "連江縣天氣小幫手");
        foreach ($locationlist as $locationKey => $locationName) {
            # code...
        
            $url = sprintf('http://opendata.cwb.gov.tw/opendata/MFC/F-C0032-%s.xml',$locationKey);
            //echo $url;
            $xmlstring = file_get_contents($url);
            if($xmlstring == FALSE)
                continue;
            $xml = simplexml_load_string($xmlstring);

            $data = array();
            $data["cityid"] = (string) $xml->data->cityid;
            $data["name"] = (string) $xml->data->name;
            $data["stno"] = (string) $xml->data->stno;
            $data["time"] = (string) $xml->data->time;
            $data["updated"] = (string) $xml->head->source->updated;
            $data["updated"] = date_create($data["updated"],timezone_open("Asia/Taipei") );
            $data["updated"] = date_format($data["updated"],"Y-m-d H:i:s");;
            //echo $data["time"]."<br>";
            if(strpos($data["time"],"上午 "))
            {
                $data["time"] = str_replace("上午 ", "", $data["time"]);
                $data["time"] = date_create($data["time"],timezone_open("Asia/Taipei") );
            }
            else
            {
                $data["time"] = str_replace("下午 ", "", $data["time"]);
                $data["time"] = date_create($data["time"],timezone_open("Asia/Taipei") );
                date_add($data["time"], date_interval_create_from_date_string('12 hours'));
            }


            $data["time"] = date_format($data["time"],"Y-m-d H:i:s");;
                        //echo $data["time"]."<br>";
            $data["memo"] = array();
            foreach ($xml->data as  $rows) {
                foreach ($rows as $key => $value) {
                    if($key=="memo")
                        $data["memo"][] = (string)$value;
                    }
            }
            $data["memo"] = implode("\n",$data["memo"]);
            $this->db->insert("WeatherAssistant",$data);

        }
    }
    public function _get_one_data($table,$data_url)
    {
        //php /home/fripig/public_html/api/weather/index.php cli get_36hour_data
        $url = 'http://opendata.cwb.gov.tw/opendata/'.$data_url;
        $xmlstring = file_get_contents($url);
        $xml = simplexml_load_string($xmlstring);
        if($xmlstring == FALSE)
                return;
        //$data_url = "MFC/F-C0032-001.xml";
        //$updatetime = $xml->head->updated;
        $updatetime = date_create($xml->head->updated,timezone_open("Asia/Taipei") );
        $updatetime = date_format($updatetime,"Y-m-d H:i:s");;
        $check = $this->db->like("url",$data_url)
                            //->where("updatetime >=",$updatetime)
                            ->get("data_state",1)
                            ->row_array();
        if($check)
        {
            //if($updatetime!=$check["updatetime"])
                $this->db->update("data_state",array("updatetime"=>$updatetime),array("url"=>$data_url));
            //else
                //return 0;
        }else
        {
            $this->db->insert("data_state",array("updatetime"=>$updatetime,"url"=>$data_url) );
        }
        //$city = $xml->data->location->name;
        //print_r($xml->data);
        $data = array();
        foreach ($xml->data as  $location)
        {


            foreach ($location as $citydata) {
                //print_r($value);
                $alldata = array();
                $data["city"] = (string) $citydata->name;
                foreach ($citydata->{'weather-elements'} as  $weatherelements) {
                    foreach ($weatherelements as $key => $datarows) {
                        //echo $key;
                        $data["class"] = $key;
                        foreach ($datarows as  $row) {
                            //print_r($row);
                            $date=date_create($row->attributes()->start,timezone_open("Asia/Taipei") );
                            $data["start"] = date_format($date,"Y-m-d H:i:s");;
                            $date=date_create($row->attributes()->end,timezone_open("Asia/Taipei"));
                            $data["end"] = date_format($date,"Y-m-d H:i:s");
                            $data["text"] = isset($row->text) ? (string)$row->text:NULL;
                            $data["value"] = (float)$row->value;
                            //print_r($data);
                            $alldata[]=$data;
                            //echo "<br>";
                        }
                    }
                }
                $this->db->insert_batch($table,$alldata);
            }
        }
    }
    public function get_obs_data()
    {
        $this->_get_obs_data("obs","DIV2/O-A0003-001.xml");
        $this->_get_obs_data("obs","DIV2/O-A0001-001.xml");
    }
    public function _get_obs_data($table,$data_url)
    {
        // $table="obs";
        // $data_url="DIV2/O-A0003-001.xml";
        //php /home/fripig/public_html/api/weather/index.php cli get_36hour_data
        $url = 'http://opendata.cwb.gov.tw/opendata/'.$data_url;
        $xmlstring = @file_get_contents($url);
        if($xmlstring == FALSE)
            return;
        $xml = simplexml_load_string($xmlstring);

        //$data_url = "MFC/F-C0032-001.xml";
        //$updatetime = $xml->head->updated;
        $updatetime = date_create($xml->sent,timezone_open("Asia/Taipei") );
        $updatetime = date_format($updatetime,"Y-m-d H:i:s");;
        $check = $this->db->like("url",$data_url)
                            //->where("updatetime >=",$updatetime)
                            ->get("data_state",1)
                            ->row_array();
        //print_r($check);
        //print_r($updatetime);
        if($check)
        {
            //if($updatetime!==$check["updatetime"])
                $this->db->update("data_state",array("updatetime"=>$updatetime),array("url"=>$data_url));
            //else
                //return 0;
        }else
        {
            $this->db->insert("data_state",array("updatetime"=>$updatetime,"url"=>$data_url) );
        }
        //$city = $xml->data->location->name;
        //print_r($xml->data);
        $data = array();
        $data["status"] = (string)$xml->status;
        $data["msgtype"] = (string)$xml->msgType;
        $data["dataid"] = (string)$xml->dataid;
        $data["scope"] = (string)$xml->scope;
        $data["status"] = (string)$xml->status;
        foreach ($xml as  $key=>$rows)
        {
            if($key=="location")
            {
                $data["locationName"]  = "{$rows->locationName}";
                $data["stationId"]  = (string)$rows->stationId;
                $data["obsTime"]  =date_create($rows->time->obstime,timezone_open("Asia/Taipei") );
                $data["obsTime"]  = date_format($data["obsTime"] ,"Y-m-d H:i:s");;
                foreach ($rows as $key2 => $row) {
                    //$data["location"] = "POINT(".$row->lat." ".$row->lon.")";
                    //print_r($row);
                    $this->db->set("location","GeomFromText('POINT(".$rows->lat." ".$rows->lon.")')",FALSE);

                    //foreach ($row as $key3 => $value) {

                        if($key2=="weatherElement")
                            $data[(string)$row->elementName] = is_numeric((string)$row->elementValue->value)? $row->elementValue->value:"'{$row->elementValue->value}'";
                        if($key2=="parameter")
                            $data[(string)$row->parameterName] = is_numeric((string)$row->parameterValue)? $row->parameterValue:"{$row->parameterValue}";
                    //}
                }
                
                $this->db->insert($table,$data);
               // echo $this->db->last_query();


                
            }

        }
    }

}

/* End of file cli.php */
/* Location: ./application/controllers/cli.php */