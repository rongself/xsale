CREATE
ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `xsv_total_profit_weekly`AS
SELECT
	`oc`.`id` AS `id`,
	sum(
		(
			(`oc`.`price` - `p`.`cost`) * `oc`.`quantity`
		)
	) AS `profit`,
	sum(
		(
			`oc`.`price` * `oc`.`quantity`
		)
	) AS `price_amount`,
	MONTH (`oc`.`create_time`) AS `month`,
	WEEK (`oc`.`create_time`, 0) AS `week`,
	YEAR (`oc`.`create_time`) AS `year`,
	cast(`oc`.`create_time` AS date) AS `date`
FROM
	(
		`xs_order_cart` `oc`
		JOIN `xs_products` `p` ON (
			(`oc`.`product_id` = `p`.`id`)
		)
	)
GROUP BY
	cast(`oc`.`create_time` AS date) ;
/**
 * Update 2014-5-26
 */
ALTER
ALGORITHM=UNDEFINED
DEFINER=`xsale`@`localhost`
SQL SECURITY DEFINER
VIEW `xsv_total_profit_weekly` AS
SELECT
	`oc`.`id` AS `id`,
	sum(
		(
			(`oc`.`price` - `p`.`cost`) * `oc`.`quantity`
		)
	) AS `profit`,
	sum(
		(
			`oc`.`price` * `oc`.`quantity`
		)
	) AS `price_amount`,
	MONTH (`o`.`order_time`) AS `month`,
	WEEK (`o`.`order_time`, 0) AS `week`,
	YEAR (`o`.`order_time`) AS `year`,
	cast(`o`.`order_time` AS date) AS `date`
FROM
	(
		(
			`xs_order_cart` `oc`
			JOIN `xs_products` `p` ON (
				(`oc`.`product_id` = `p`.`id`)
			)
		)
		JOIN `xs_orders` `o` ON ((`oc`.`order_id` = `o`.`id`))
	)
GROUP BY
	cast(`o`.`order_time` AS date) ;

-- Update 2014.06.04
ALTER
ALGORITHM=UNDEFINED
DEFINER=`xsale`@`localhost`
SQL SECURITY DEFINER
VIEW `xsv_total_profit_weekly` AS
SELECT
	`oc`.`id` AS `id`,
	sum(
		(
			(`oc`.`price` - `p`.`cost`) * `oc`.`quantity`
		)
	) AS `profit`,
	sum(
		(
			`oc`.`price` * `oc`.`quantity`
		)
	) AS `price_amount`,
	sum(`oc`.`quantity`) AS `quantity_amount`,
	MONTH (`o`.`order_time`) AS `month`,
	WEEK (`o`.`order_time`, 0) AS `week`,
	YEAR (`o`.`order_time`) AS `year`,
	cast(`o`.`order_time` AS date) AS `date`
FROM
	(
		(
			`xs_order_cart` `oc`
			JOIN `xs_products` `p` ON (
				(`oc`.`product_id` = `p`.`id`)
			)
		)
		JOIN `xs_orders` `o` ON ((`oc`.`order_id` = `o`.`id`))
	)
GROUP BY
	cast(`o`.`order_time` AS date) ;



