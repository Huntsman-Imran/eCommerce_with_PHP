<?
/*
**tile function v1.0
**title function that echo the page title in the case 
**in the case case the page hase a $pageTitle variable
*/

function getTitle()
{
	global $pageTitle;

	if(isset($pageTitle))
	{
      echo $pageTitle;
	}
	else
	{
		echo 'Default';
	}
}

/*
**Home redirect function v1.0
**function to redirect user to home[this function takes parameters]
**$errMessage= echo error message
**$second= second before redirecting
*/

function redirectHome($Message,$url=null, $second=3)
{
	if ($url==null) 
	{
		$url='index.php';
		$link='Homepage';
	}
	else
	{
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) 
		{
			$url=$_SERVER['HTTP_REFERER'];
			$link='Previous Page';
		}
		else
		{
			$url='index.php';
			$link='Homepage';
		}
	}
     echo $Message;
     echo '<div class="alert alert-info"> You Will Be Redirect To '.$link.' After '.$second.' Seconds</div>';
     header('refresh:'.$second.';url='.$url);// ei line e problem ache solve korte hobe
     exit();
}
/*
**Chectk items function v1.0
**function to check items in database[function takes parameters]
**$select=the item to select
**$from=the table to select from
**$value=the value of select
*/
function checkItem($select,$from,$value)
{
	global $conn;  //this is very important declare it as golbal
     $statement=$conn->prepare('SELECT '.$select.' FROM '.$from.' WHERE '.$select.'=?');
     $statement->execute(array($value));
     $count=$statement->rowCount();
     return $count;
}
/*
**Chectk items function v1.0
**function to check items in database[function takes parameters]
**$select=the item to select
**$from=the table to select from
**$value=the value of select
*/

function getlatest($select,$from,$order,$limit)
{
	 global $conn;  //this is very important declare it as golbal
     $statement=$conn->prepare('SELECT '.$select.' FROM '.$from.' ORDER BY '.$order.' DESC  LIMIT '.$limit);
     $statement->execute();
     $result=$statement->fetchAll();
     return $result;

}

/*
**Count items function v1.0
**function to count items in database[function takes parameters]
**$select=the item to select
**$from=the table to select from
*/

function countItems($select,$from)
{
	global $conn;
    $statement=$conn->prepare('SELECT '.$select.' FROM '.$from);
    $statement->execute();
    $result=$statement->rowCount();
     return $result;
     exit();
 
 
}
