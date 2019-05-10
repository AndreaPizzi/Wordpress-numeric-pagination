# Wordpress-numeric-pagination
How to Add Numeric Pagination in Your WordPress Theme

/**
 * 
 * Wordpress numeric pagination with:
 * - prev / next link can be visible or not [ line 27 ]]
 * - prev / next symbol [ line 25/26 ]
 * - text before pagination ( immediatly on left ) [ line 29 ]
 * - can show number as decimal ( 01 ) or not ( 1 ) [ line 30 ]
 * - Choose how many element for page to display, you can add different conditions [ line 17 ]
 *  **/
 
Add directly in your theme function.php and, where you want the pagination appears ( outside the loop ) add this :
<?php collio_numeric_posts_nav(); ?>

