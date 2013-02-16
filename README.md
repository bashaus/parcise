# PARCISE - phpActiveRecord CodeIgniter Session

Version 1.0

Enables [CodeIgniter](http://ellislab.com/codeigniter) to communicate with a database via [phpActiveRecord](http://www.phpactiverecord.org/) to store session information instead of the CodeIgniter database helper.

## Project Details

### Use case

If you're developing a PHP application with the CodeIgniter framework as a base and phpActiveRecord for database communication, you can use these scripts to ensure that only one connection is made to the database from your application.

### Setup

* Open your existing CodeIgniter framework with phpActiveRecord already installed
* Open your application/config/autoload.php file and remove references to phpActiveRecord and the Session library
* Copy the files in the repository to their respective directories in the application folder
* Edit the file aplication/core/MY_Controller.php file and set your phpActiveRecord connection parameters

## Licence

Copyright &copy; 2013, [Bashkim Isai](http://www.bashkim.com.au)

This script is distributed under the MIT licence.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

## Contributors

* @bashaus -- [Bashkim Isai](http://www.bashkim.com.au/)

If you fork this project and create a pull request add your GitHub username, your full name and website to the end of list above.