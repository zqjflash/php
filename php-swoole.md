### swoole与phpdaemon/reactphp/workerman等纯php网络库的差异

#### 为什么swoole非要使用纯c来写而不是PHP代码来实现？

核心的原因有2点：

1. PHP无法直接调用操作系统API

如sendfile、eventfd、timefd、pthread等等，所以纯php实现的phpdaemon、reactphp，workerman，这些框架都是基于PHP的sockets/pcntl/stream/libevent扩展实现，很多功能无法实现：如

 * 多线程
 * 毫秒定时器（PHP只有秒级定时器）
 * 标准输入输出重定向
 * mysql/curl异步化
 * 守护进程化
 * sendfile

而C写的swoole可以直接调用操作系统底层API，没有局限，swoole可以实现任何功能特性。

2. PHP的内存管理粒度太粗

> php内存管理比较困难，基本上只有Array可用，在高并发大负载的网络Server中，内存复制就是性能杀手，php根本就无法解决

举一个例子，客户端向服务端发起一个800K的包，每次发送8K，共发送100次。Server也会分成100次收到数据。那么PHP中拼接此数据包的方法是$package .= $recv_data。共需要复制100次内存，第一次为8K + 8K，第二次16K + 8K，第三次24K + 8K，依次类推，仅仅一次请求就发生了大量的内存拷贝，如果每秒有10万次请求，这个Server的性能就极差。

而纯C的代码可以做到0次内存拷贝，在请求到来申请一块800K的buffer内存，通过指针运算，直接将数据写入buffer，内存拷贝为0.

当然这里仅是其中一个小小的点，真正的代码中不止这些。通过压测也能发现，纯C的swoole写一个EchoServer，做-c 500 -n 100000的测试中，CPU始终在5%-10%之间。而PHP实现的PSF网络Server框架，CPU占用率高达70%-90%。

以上也就是swoole和其他网络框架的差异。除此之外swoole以扩展方式提供，免去了代码中include php文件的问题。不需要去包含一堆外部文件，更容易融合到现有代码中。使用者仅需掌握swoole扩展的API即可。reactphp提供了API封装，耦合程度较低。phpdaemon/workerman耦合太高，不是你的代码集成它们，而是它们的代码集成你的代码。而且还需要了解其内部结构和耦合关系。

再看swoole，它其实就像MySQL之类的扩展一样，仅仅是作为一层API存在，耦合度非常低。swoole一直坚持低耦合高内聚，API化。用户可以方便的将swoole的功能集成到自己的代码中。

