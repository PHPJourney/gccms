var ticketPreOrder = function(date,checi,starttime,xibie){
	var begin = $("#fromStation").val();
	var end = $("#toStation").val();
	var queryleftTicketUrl = "https://kyfw.12306.cn/otn/leftTicket/queryZ?leftTicketDTO.train_date="+ date +"&leftTicketDTO.from_station="+ begin +"&leftTicketDTO.to_station="+ end + "&purpose_codes=ADULT";
	var secretStr='';
	var appoint=new Array();
	var xhr = new XMLHttpRequest();
	xhr.open("get",queryleftTicketUrl);
	xhr.onreadystatechange = function(){
		if(xhr.status==200 && xhr.readyState==4){
			var json = eval("("+xhr.responseText+")");
		 if(false !==json.status && json.httpstatus==200){
                var data = json.data;
                for(var i=0;i<data.length;i++){
                    var jsonData = data[i].queryLeftNewDTO;
console.info(jsonData);
					if(!data[i].queryLeftNewDTO['station_train_code'].indexOf(checi)){
						console.info("车次："+jsonData['station_train_code']+"\r\n发车时间："+jsonData['start_time']+"\r\n总时长："+jsonData['lishi']+"\r\n 商务座："+ jsonData['swz_num']+"\r\n特等座："+jsonData['tz_num']+"\r\n 一等座："+jsonData['zy_num']+"\r\n二等座："+jsonData['ze_num']+"\r\n高级软卧："+jsonData['gr_num']+"\r\n软卧："+jsonData['rw_num']+"\r\n硬卧："+jsonData['yw_num']+"\r\n软座："+jsonData['rz_num']+"\r\n硬座："+jsonData['yz_num']+"\r\n无座："+jsonData['wz_num']+"\r\n其它："+jsonData['qt_num']);
						if(jsonData['start_time']==starttime && jsonData.secretStr!='' && jsonData[xibie+'_num']!="--"){
                               secretStr = data[i].secretStr;
							   appoint = jsonData;
                        }
                	}
                }
				 appoint!='' && secretStr!='' ? checkG1234(secretStr,appoint['start_time'],appoint['train_no'],appoint['from_station_telecode'],appoint['to_station_telecode']) : '';
            }
        }
    }
	xhr.send();
}
setInterval(function(){ ticketPreOrder("2016-12-28","G","06:30","yw"); },500); //2016-12-29 日期 |车次类型  G 高铁 D动车 Z直达 T特快 K 快速 QT其它  商务座：swz 特等座：tz 一等座：zy 二等座：ze 高级软卧：gr 软卧：rw 硬卧：yw 软座：rz 硬座：yz 无座：wz 其它：qt