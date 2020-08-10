# Logic Test Application

This project consist in resolve a little problem, using logic.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.
By default, this project was develop to execute on command line interface.

### Prerequisites

* PHP (>=7.2)


### Installing

You only need download files and execute the main file **walk**.

>note: file doesn't have extension *.php* because is declared in first lines of the file by: #!/usr/bin/env php

###Basic Execution
```
php walk --rows=5 --columns=5
```
>By default --rows are 3 and --columns are 3.

Script has a last argument and determine if you want to see the grid.
```
php walk --rows=5 --columns=5 --show-grid=letter

Test for (5,5)

[ R ][ R ][ R ][ R ][ R ] 
[ U ][ R ][ R ][ R ][ D ] 
[ U ][ U ][(R)][ D ][ D ] 
[ U ][ L ][ L ][ D ][ D ] 
[ L ][ L ][ L ][ L ][ D ] 

The output for the test are: R

```
>--show-grid expect only **letter** or **symbol**.

> **(R)** will determine the output test on the grid.

## Built With

* [PHP](https://www.php.net/) - A general-purpose scripting language that is especially suited to web development.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags). 

## Authors

* **Cristian Cordova** - *Initial work* - [criscordovaa](https://github.com/criscordovaa)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details
