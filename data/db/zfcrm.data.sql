INSERT INTO `contact` (`first_name`, `last_name`, `created`, `modified`)
  VALUES
  ('Michelangelo', 'van Dam', NOW(), NOW());

INSERT INTO `contact_email` (`contact_id`, `email_address`, `primary`, `created`, `modified`)
  VALUES
  (1, 'michelangelo@in2it.be', 1, NOW(), NOW()),
  (1, 'dragonbe@gmail.com', 0, NOW(), NOW());

INSERT INTO `contact_address` (contact_id, street_1, street_2, postcode, city, province, country_code, created, modified)
  VALUES
    (1, 'Battelsesteenweg 134', '', '2800', 'Mechelen', 'Antwerp', 'BE', NOW(), NOW());