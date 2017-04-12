<?
function lang($phrase)
{
     static $lang=array(
        
         'HOME_ADMIN'=>'Home', 
         'ITEMS'=>'Items',
         'CATEGORIES'=>'Categories', 
         'MEMBERS'=>'Members',
         'STATISTICS'=>'Statistics', 
         'COMMENTS'=>'Comments',
         'LOGS'=>'Logs'

     	);
     return $lang[$phrase];
}

?>