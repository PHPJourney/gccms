<?php
/**
1）merchant_private_key，商户私钥;merchant_public_key,商户公钥；商户需要按照《密钥对获取工具说明》操作并获取商户私钥，商户公钥。
2）demo提供的merchant_private_key、merchant_public_key是测试商户号1118004517的商户私钥和商户公钥，请商家自行获取并且替换；
3）使用商户私钥加密时需要调用到openssl_sign函数,需要在php_ini文件里打开php_openssl插件
4）php的商户私钥在格式上要求换行，如下所示；
*/
	$merchant_private_key='-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAMXzGf588R76YwwR
ZfUHX/pvRA0+dkP/gC3Yfo1dJmyhrzN1hEsZ8z8jMt2RyLnrSZ7KpjstC4smS9cf
VUq4N4TdFuyKv/LwNTNQvpcX18S7OE8ZZiAtEnNGQ57eQql06//0jggkB4y5mhIb
ngeD16smUtiYY5gwegLqp7sQQZyRAgMBAAECgYEAiEdQawsbeYdKL2G+/s1f/2sg
v7lz9GZvmaCFp88sh/dcRiIuvQGVnK8f8rjOJ2lcGu1LOkxNuTPZXLYeoz1mQmQI
/Dlcw9b3DNwTWuaYNGV+ljJpfnOO3IFXYFlvRZIbBNrIOloE7zHkIyVrdweSmhZG
fuZ0gHkqDrUKEdDpuRECQQD34xJFiSKNwTLfO2E+s91H/B+JwNY2wDPBa4OgQhdh
lhMDw8TfCONU6dda/ATIppEJrTfL180xBvkKYwXgnX+VAkEAzG2g2UNKK52b/I+r
mrLUTW+PE0ae9OmR/Nj1kZSosfZ35Sh8+5zgcrCNfdeTRH2VDHTCCXJ/ytrpPreW
dNkaDQJAdyRJZOh7lhxUohx9KdDzOyT/14q6qsgIWB+fvQfnCv1BmF6gof44nVhj
LJTSi8obDcaWeb/4HGdYjVh4u7OXXQJAWsVi4pXKXUuCc8anf+1f73JVqU12T3FW
7Vq4z4ee0EaMPiiYNnEWCFb0vKf4MDVC9WDyt5crvzsszjheikvMEQJBAMfDUpgR
1rLrbqS/VD5YzN2sx0h1jdJFdag1vTlHTtyRgin5d8r7Eb0G1PiaOIbp/kj4Y/rH
E59D7jBg9IafIVE=
-----END PRIVATE KEY-----';

	//merchant_public_key,商户公钥，按照说明文档上传此密钥到智付商家后台，位置为"支付设置"->"公钥管理"->"设置商户公钥"，代码中不使用到此变量
	$merchant_public_key = '-----BEGIN PUBLIC KEY-----
	MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDF8xn+fPEe+mMMEWX1B1/6b0QNPn
	ZD/4At2H6NXSZsoa8zdYRLGfM/IzLdkci560meyqY7LQuLJkvXH1VKuDeE3Rbsir/y
	8DUzUL6XF9fEuzhPGWYgLRJzRkOe3kKpdOv/9I4IJAeMuZoSG54Hg9erJlLYmGOYMH
	oC6qe7EEGckQIDAQAB
	-----END PUBLIC KEY-----';
	
/**
1)dinpay_public_key，智付公钥，每个商家对应一个固定的智付公钥（不是使用工具生成的密钥merchant_public_key，不要混淆），
即为智付商家后台"公钥管理"->"智付公钥"里的绿色字符串内容,复制出来之后调成4行（换行位置任意，前面三行对齐），
并加上注释"-----BEGIN PUBLIC KEY-----"和"-----END PUBLIC KEY-----"
2)demo提供的dinpay_public_key是测试商户号1118004517的智付公钥，请自行复制对应商户号的智付公钥进行调整和替换。
3）使用智付公钥验证时需要调用openssl_verify函数进行验证,需要在php_ini文件里打开php_openssl插件
*/
		$dinpay_public_key ='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDZDirdU1syeYUoKJq
t2QoxDHiWE4WNoewR0DBWlqMtQRC0GK9+v9QGG+WDTcIRiJr5tVusJo
4hK/B5YYWlJs7ubrMSqFs7dWPrfplPYZUmR6J667c46tR6aDuD3vmoP
viUXrIgrJRxgYCfl5wETvL8FIH2datclMtJuSba9+73nwIDAQAB 
-----END PUBLIC KEY-----'; 	
	



?>