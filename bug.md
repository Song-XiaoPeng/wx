### 1.天气查询功能遇到的bug
` {"status":240,"message":"APP服务被禁用"}`

解决方法：
创建应用选择类型时：使用微信小程序，而不是服务端，因为服务端没有天气查询api

### 修复.gitignore无法忽略文件的bug
[.gitignore文件不起作用](https://www.jianshu.com/p/4a1f4b324823)

根本原因:

.gitignore文件只是ignore没有被staged(cached)文件，对于已经被staged文件，加入ignore文件时一定要先从staged移除。

因此，要想用gitignore忽略文件，必须先把它们从staged中移除：
commit你已有的改变，保存当前的工作。
git rm --cached file/path/to/be/ignored。
git add .
git commit -m "fixed untracked files"

### nginx查看日志
`error_log /var/log/nginx/error.log; 错误日志`

`access.log 记录访问日志`
```
find / -name nginx.conf //查找日志存放地址

vim /etc/nginx/nginx.conf

tail -f -30  "/private/var/log/apache2/access_log"  //tail 命令从指定点开始将文件写到标准输出.使用tail命令的-f选项可以方便的查阅正在改变的日志文件,tail -f filename会把filename里最尾部的内容显示在屏幕上,并且不但刷新,使你看到最新的文件内容

tail[必要参数][选择参数][文件]   
2．命令功能：

用于显示指定文件末尾内容，不指定文件时，作为输入信息进行处理。常用查看日志文件。

3．命令参数：

-f 循环读取

-q 不显示处理信息

-v 显示详细的处理信息

-c<数目> 显示的字节数

-n<行数> 显示行数

--pid=PID 与-f合用,表示在进程ID,PID死掉之后结束. 

-q, --quiet, --silent 从不输出给出文件名的首部 

-s, --sleep-interval=S 与-f合用,表示在每次反复的间隔休眠S秒 


1. access_log 访问日志

access_log为访问日志,记录所有对apache服务器进行请求的访问,它的位置和内容由CustomLog指令控制,LogFormat指令可以用来简化该日志的内容和格式 


2. error_log 错误日志

error_log为错误日志,记录下任何错误的处理请求,它的位置和内容由ErrorLog指令控制,通常服务器出现什么错误,首先对它进行查阅,是一个最重要的日志文件。


100.109.195.91 - - [17/Feb/2017:00:08:11 +0800] "GET /data/upload/shop/common/loading.gif HTTP/1.0" 200 134 "http://www.mall121.com/" "Mozilla/4.0 (compatible; MSIE 8.0; Trident/4.0; Windows NT 6.1; SLCC2 2.5.5231; .NET CLR 2.0.50727; .NET CLR 4.1.23457; .NET CLR 4.0.23457; Media Center PC 6.0; MS-WK 8)" "140.205.201.12"  
100.109.195.78 - - [17/Feb/2017:00:08:11 +0800] "GET /shop/templates/default/images/u-safe.png HTTP/1.0" 200 3675 "http://www.mall121.com/" "Mozilla/4.0 (compatible; MSIE 8.0; Trident/4.0; Windows NT 6.1; SLCC2 2.5.5231; .NET CLR 2.0.50727; .NET CLR 4.1.23457; .NET CLR 4.0.23457; Media Center PC 6.0; MS-WK 8)" "140.205.201.12"  
100.109.195.26 - - [17/Feb/2017:00:08:11 +0800] "GET /data/upload/shop/adv/05240495346955824.jpg HTTP/1.0" 404 564 "http://www.mall121.com/" "Mozilla/4.0 (compatible; MSIE 8.0; Trident/4.0; Windows NT 6.1; SLCC2 2.5.5231; .NET CLR 2.0.50727; .NET CLR 4.1.23457; .NET CLR 4.0.23457; Media Center PC 6.0; MS-WK 8)" "140.205.201.12"  



```
[日志-nginx的access_log与error_log](http://blog.csdn.net/ty_hf/article/details/55518070)

[日志-apache的access_log与error_log](http://blog.csdn.net/ty_hf/article/details/55504719)
1.100.109.195.91 :

$remote_addr : 客户端（用户）IP地址 

2.[17/Feb/2017:00:08:11 +0800]:

$time_local  :访问时间

3."GET /data/upload/shop/common/loading.gif HTTP/1.0"  :

"$request"get请求的url地址（目标url地址）的host

4.200:

'$status请求状态状态码，200表示成功，404表示页面不存在，301表示永久重定向等，具体状态码可以在网上找相关文章，不再赘述）

5. 134 :

$body_bytes_sent ：请求页面大小，默认为B（byte

6."http://www.mall121.com/" :

"$http_referer" : 来源页面，即从哪个页面转到本页，专业名称叫做“referer”

7."Mozilla/4.0 (compatible; MSIE 8.0; Trident/4.0; Windows NT 6.1; SLCC2 2.5.5231; .NET CLR 2.0.50727; .NET CLR 4.1.23457; .NET CLR 4.0.23457; Media Center
 PC 6.0; MS-WK 8)":

$http_user_agent:用户浏览器其他信息，浏览器版本、浏览器类型

8. "140.205.201.12" :

$http_x_forwarded_for": http扩展头