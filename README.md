### Introduction
Time of development is developers' main concern, which they always try to decrease when involved in any project. So,  this package helps them finish their takes fast and easily by using time-shortening pre-defined method having the ability to end all service processes in the blink of an eye.
</br>
As we know, Design patterns represent the best practice that the developers use to solve the general problems 
that they face during software development, so in this library, we use a Repository pattern to implement all API functionality whether they were simple CRUD or even complex ones
### Installation

```sh
$ composer require red-code/master-package
```
copy service provider link to config/app.php , providers[]

```sh
MP\Base\MasterPackageServiceProvider::class
```
then you should publish library's config file by typing the following command
```sh
$ php artisan vendor:publish --provider=MP\Base\MasterPackageServiceProvider
```

### Request Flow
Route -> Controller -> Request -> Controller's method -> Repository's method -> Resource -> Back to controller's method

### How to use
You should follow the following instruction to take the advantages that the library supports

#### Controller
After creating your own controller, you should inherit library's controller 
```sh
class Controller extends \MP\Base\Http\Controllers\Controller
{
    protected $request = {RequestClass}::class;
    protected $repository = {RepositoryClass}::class;
} 
```
After validating request's data, Controller moves the request to Repository's method which it does have the same name of called controller's method
to perform the intended actions.

For CURD operations, you won't need to create any methods in Repository class 'cause they are already implemented in the Parent repository, otherwise
you should create method with the same name of the called controller's method.

#### Request
```sh
 class Request extends \MP\Base\Http\Requests\Request
 {
 }
```

#### Repository
```sh
class Repository extends \MP\Base\Repositories\Repository
{
    protected $model = {ModelClass}::class;
    protected $resource = {ResourceClass}::class;
}
```

Repository class calls Resource `serializeFor{repository'sMethod}` method automatically, if you are working on the simple CRUD methods, otherwise you should use
```sh
$this->collection($data, $isList = false, $name = null) 
```
to call the resource's method, so you can customize the returned data easily

##### Notes:
  - You can call any method from Resource even if that method does not have `serializeFor{repository'sMethod}` name by passing its name as a third parameter of collection method. 
  - Guess what, you can customize the data attribute of Pagination Object easily without any further complexity, by passing PaginationObject to the collection method and mark it as a list by passing true value to the second parameter of the same collection method
#### Resource 
```sh
class Resource extends \MP\Base\Http\Resources\Resource
{
}
```
Resource object returns the result of `toArray($request)` for all undefined called method, otherwise it returns the result of defined called methods

### Recommendation
We recommend you to use [LModular](https://github.com/PShadowClone/LModular) if you want to get the benefits of the auto dependency injection which is the way that the library use to detect **Resource**, **Repository**, **Request**, and **Model** automatically
by creating the package with the same structure that the [LModular](https://github.com/PShadowClone/LModular) does, and naming all previous classes with the same name of the **Model** class.

