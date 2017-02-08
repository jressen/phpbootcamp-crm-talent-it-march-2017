INSERT INTO `contact` (`first_name`, `last_name`, `created`, `modified`)
    VALUES ('Michelangelo', 'van Dam', NOW(), NOW());

INSERT INTO `contact_email` (`contact_id`, `email_address`, `primary`, `created`, `modified`)
    VALUES (1, 'michelangelo@in2it.be', 1, NOW(), NOW()),
    (1, 'dragonbe@gmail.com', 0, NOW(), NOW());