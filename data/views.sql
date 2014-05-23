CREATE
ALGORITHM=UNDEFINED
SQL SECURITY DEFINER
VIEW `NewView`AS
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