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
						console.info("���Σ�"+jsonData['station_train_code']+"\r\n����ʱ�䣺"+jsonData['start_time']+"\r\n��ʱ����"+jsonData['lishi']+"\r\n ��������"+ jsonData['swz_num']+"\r\n�ص�����"+jsonData['tz_num']+"\r\n һ������"+jsonData['zy_num']+"\r\n��������"+jsonData['ze_num']+"\r\n�߼����ԣ�"+jsonData['gr_num']+"\r\n���ԣ�"+jsonData['rw_num']+"\r\nӲ�ԣ�"+jsonData['yw_num']+"\r\n������"+jsonData['rz_num']+"\r\nӲ����"+jsonData['yz_num']+"\r\n������"+jsonData['wz_num']+"\r\n������"+jsonData['qt_num']);
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
setInterval(function(){ ticketPreOrder("2016-12-28","G","06:30","yw"); },500); //2016-12-29 ���� |��������  G ���� D���� Zֱ�� T�ؿ� K ���� QT����  ��������swz �ص�����tz һ������zy ��������ze �߼����ԣ�gr ���ԣ�rw Ӳ�ԣ�yw ������rz Ӳ����yz ������wz ������qt