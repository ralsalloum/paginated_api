### What is used?

PHP version 7.4.11 with Symfony Framework version 5.1
KnpPaginatorBundle version 5.4

### Aim of Pagination

Pagination is a technique that helps us in increasing the performance of a symphony application. It gives us the ability to organize the returned records of a table in the database into pages, instead of displaying all the records together at the same time, and we can notice the difference when we have thousands of rows.

### Required Bundle

In order to use pagination in our project we need to install KnpPaginatorBundle. That’s done via the following command:
composer require knplabs/knp-paginator-bundle
Enabling the bundle happens automatically on the app/config/bundles.php in Symfony 4 and in the versions later, due to Flex.

### ### Using Paginator

First, make sure that our controller extends the AbstractController class as this is the one that allows you to access multiple services with the get method of the class.

Second, follow the scenario to use the Paginator:
Instantiate the paginator and keep it on a variable (Dependency Injection):

*class DefaultController extends AbstractController
{
    public function index(Request $request, PaginatorInterface $paginator)
    {
…*
Then, create some Doctrine query (Query, not results):

$em = $this->getDoctrine()->getManager();
$productRepository = $em->getRepository(Product::class);
$query = $ productRepository ->createQueryBuilder(‘p’)
            ->getQuery();

And then call the paginate method from the paginator and provide its 3 required arguments:

- The Doctrine Query.
- The current page, defined by the get parameter "page" and set the first page as default when this parameter doesn't exist.
- The limit of items per page.

*$products = $paginator->paginate(
            $query,
            $request->request->getInt('page', 1),
            5
        );*

Finally, render the returned value of the paginator via a Twig view: 

*return $this->render('default/index.html.twig',
            [‘products ‘=>$products]
        );*

In our example, we rendered the response in the anime.html.twig file which exists in the folder templates/default. The file is a simple html one, except it contains a placeholder for the content that we need to display and a pagination slider:

```
{# ./templates/default/index.html.twig #}
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Application</title>
</head>
<body>
<ul>
    {% for product in products %}
        <li>
            {{ product.name }}
        </li>
    {% endfor %}
</ul>

<div class="navigation">
    {{ knp_pagination_render(products) }}
</div>
</body>
</html>
```

Make sure to uncomment the route setting in the routes.yaml in the config folder.

*index:
    path: /
    controller: App\Controller\DefaultController::index*

-----
### References
https://ourcodeworld.com/articles/read/802/how-to-install-the-knppaginatorbundle-to-paginate-doctrine-queries-in-symfony-4
