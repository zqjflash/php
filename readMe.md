### 1. nginx使用哪种网络协议？

nginx是应用层协议，由下至上，传输层用的是tcp/ip，应用层用的是http，fastcgi负责调度进程。

### 2. echo(), print(), print_r()的区别？

echo是语言结构，无返回值；print功能和echo基本相同，不同的是print是函数，有返回值；print_r是递归打印，用于输出数组对象。

###  3. PHP有哪些特性？

    * php独特混合了C，Java，Perl以及PHP自创的语法；
    * 可以比CGI或者Perl更快速去执行动态网页，与其它编程语言相比，PHP是将程序嵌入到HTML文档中执行，执行效率比完全生成HTML编辑的CGI要高很多，所有的CGI都能实现；
    * 支持几乎所有流行的数据库以及操作系统；
    * 可以使用C，C++进行程序的扩展。

### 4. 求数组中最大数的下标？

示例数组：$arr = [0, -1, -2, 5, "b" => 15, 3];

```js
function maxKey($arr) {
    $maxVal = max($arr);
    foreach ($arr as $key => $val) {
        if ($maxVal == $val) {
            $maxKey = $key;
        }
    }
    return $maxKey;
}
echo maxKey($arr);
```

输出结果为：b

### 5. 对于大流量的网站，您采用什么样的方法来解决访问量问题？

    * 有效使用缓存，增加缓存命中率；
    * 使用负载均衡；
    * 对静态文件使用CDN进行存储和加速；
    * 尽量减少数据库的使用；
    * 查看出现统计的瓶颈在哪里。

### 6. 谈谈asp, php, jsp的优缺点？

    * asp是需要依赖IIS,是微软开发的语言；
    * php和jsp可以依赖apache或者 nginx等其他服务器；

### 7. 简述两种屏蔽php程序的notice警告的方法 ？

初始化变量，文件开始设置错误级别或者修改php.ini 设置error_reporting set_error_handler

    * 在程序中添加：error_reporting (E_ALL & ~E_NOTICE); 
    * 修改php.ini中的：error_reporting = E_ALL 改为：error_reporting = E_ALL & ~E_NOTICE 
    * error_reporting(0);或者修改php.inidisplay_errors=Off

### 8. 下面哪个选项没有将 john 添加到users 数组中? （B）

    * (A) $users[] = 'john';
    * (B) array_add($users,'john');
    * (C) array_push($users,'john');
    * (D) $users += ['john']; 

### 9.写一个函数，尽可能高效的，从一个标准 url 里取出文件的扩展名?

例如: http://www.sina.com.cn/abc/de/fg.php?id=1 需要取出 php 或 .php?

```js
$url = "http://www.sina.com.cn/abc/de/fg.php?id=1";
$arr = parse_url($url);
$pathArr = pathinfo($arr['path']);
print_r($pathArr['extension']);   
```

### 10.写一个函数，能够遍历一个文件夹下的所有文件和子文件夹？

```js
<?php
function aGetAllFile($folder) {
    $aFileArr = [];
    if(is_dir($folder)) {
        $handle = opendir($folder);
        while (($file = readdir($handle)) !== false) {
            //如果是.或者..则跳过
            if($file == "." || $file == "..") {
                continue;
            }
            if(is_file($folder . "/" . $file)) {
                $aFileArr[] = $file;
            } else if (is_dir($folder . "/" . $file)) {
                $aFileArr[file] = aGetAllFile($folder . "/" . file);
            }
        }
        closedir($handle);
    }
    return $aFileArr;
}
$path = "/source/github/php/php-base";
print_r(aGetAllFile($path));
```


