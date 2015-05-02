# ThinkPHP-UnitTest
An UnitTest Practise For ThinkPHP, which refers to JUnit and Cucumber

对于单元测试框架的需求：
- 自动执行
- 断言
- 多种访问方式
- 非侵入性
考虑的技术点：
- 自定义Http Client
- 利用类的反射机制
- 动态绑定Session

由于不能像JUnit那样做到自动回滚或者事物回滚，考虑模拟Rails里面cucumber的方式，编辑出合适的测试用例。

访问方式：
domain.com/test.php
