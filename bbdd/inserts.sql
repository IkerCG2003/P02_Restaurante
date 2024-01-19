INSERT INTO user (fullName, email, pwd) VALUES
("Iker Catalan", "icatalan@gmail.com", "$2y$10$1.6ysGxnMW49aE70a37r8u.GPcWImphiHb7ASf7bLz/Oewp5Jpi0S"), /* asdASD123 */
("Eric Molina", "emolina@gmail.com", "$2y$10$1.6ysGxnMW49aE70a37r8u.GPcWImphiHb7ASf7bLz/Oewp5Jpi0S"), /* asdASD123 */
("Daniel Font", "dfont@gmail.com", "$2y$10$1.6ysGxnMW49aE70a37r8u.GPcWImphiHb7ASf7bLz/Oewp5Jpi0S"); /* asdASD123 */

INSERT INTO room (name) VALUES
("Terraza 1"), ("Terraza 2"), ("Terraza 3"),
("Comedor 1"), ("Comedor 2"),
("Sala privada 1"), ("Sala privada 2"), ("Sala privada 3"), ("Sala privada 4");

/*
terrazas 5mesas de 3personas
comedor 10mesas de 4personas
sala privada 1mesa de 10personas
*/

INSERT INTO `table` (name, capacity, available, room_id) VALUES
("01", 3, true, 1), ("02", 3, true, 1), ("03", 3, true, 1), ("04", 3, true, 1), ("05", 3, true, 1), /* Terraza 1 */
("01", 3, true, 2), ("02", 3, true, 2), ("03", 3, true, 2), ("04", 3, true, 2), ("05", 3, true, 2), /* Terraza 2 */
("01", 3, true, 3), ("02", 3, true, 3), ("03", 3, true, 3), ("04", 3, true, 3), ("05", 3, true, 3), /* Terraza 3 */

("01", 4, true, 4), ("02", 4, true, 4), ("03", 4, true, 4), ("04", 4, true, 4), ("05", 4, true, 4), /* Comedor 1 */
("06", 4, true, 4), ("07", 4, true, 4), ("08", 4, true, 4), ("09", 4, true, 4), ("10", 4, true, 4), 
("01", 4, true, 5), ("02", 4, true, 5), ("03", 4, true, 5), ("04", 4, true, 5), ("05", 4, true, 5), /* Comedor 2 */
("06", 4, true, 5), ("07", 4, true, 5), ("08", 4, true, 5), ("09", 4, true, 5), ("10", 4, true, 5), 

("01", 10, true, 6), /* Mesa de 8personas en Sala privada 1 */
("01", 10, true, 7), /* Mesa de 8personas en Sala privada 2 */
("01", 10, true, 8), /* Mesa de 8personas en Sala privada 3 */
("01", 10, true, 9); /* Mesa de 8personas en Sala privada 4 */

