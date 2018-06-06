-- View Characters
SELECT character.name, era.name, equip_type.name, character.element FROM `character`
INNER JOIN era ON era.id = character.eid
INNER JOIN equip_type ON equip_type.id = character.etid;

-- Add a Character
INSERT INTO `character`(name, eid, etid, element) 
VALUES ([typed name],[selected era],[selected equip_type],[selected element]);

-- View Techs and Combos by Character
SELECT tech.name, magic_cost, targets, description FROM `tech`
INNER JOIN performs ON performs.tid = tech.id
INNER JOIN `character` ON character.id = performs.cid
WHERE character.id = [current character] UNION 
SELECT combo.name, tech.magic_cost, tech.targets, combo.description FROM combo
INNER JOIN tech ON tech.id = combo.tid_1 OR tech.id = combo.tid_2 OR tech.id = combo.tid_3
INNER JOIN performs ON performs.tid = tech.id
INNER JOIN `character` ON character.id = performs.cid
WHERE character.id = [current character];

-- Add a Tech by Character
INSERT INTO tech(name, magic_cost, targets, description) 
VALUES ([typed name],[number input],[number input],[typed description]);
INSERT INTO performs(cid, tid) 
VALUES ([current character],[added tech]);

-- View Weapons by Character
SELECT equipment.name, equip_type.name, attack, effect FROM `equipment`
INNER JOIN equip_type ON equip_type.id = equipment.etid
INNER JOIN utilizes ON utilizes.eqid = equipment.id
INNER JOIN `character` ON character.id = utilizes.cid
WHERE character.id = [current character] AND equipment.attack != 0;

-- View Armor and Headgear by Character
SELECT equipment.name, equip_type.name, defense, effect FROM `equipment`
INNER JOIN equip_type ON equip_type.id = equipment.etid
INNER JOIN utilizes ON utilizes.eqid = equipment.id
INNER JOIN `character` ON character.id = utilizes.cid
WHERE character.id = ? AND equipment.defense != 0;

-- View Accessories by Character
SELECT equipment.name, effect FROM `equipment`
INNER JOIN equip_type ON equip_type.id = equipment.etid
INNER JOIN utilizes ON utilizes.eqid = equipment.id
INNER JOIN `character` ON character.id = utilizes.cid
WHERE character.id = ? AND equip_type.name = 'accessory';

-- Add a piece of Equipment
INSERT INTO equipment (name, etid, attack, defense, effect) 
VALUES ([typed name],[selected equip_type],[number input],[number input],[typed effect]);

-- Quest Dropdown
SELECT id, name FROM `quest`;

-- View Locations by Quest
SELECT location.id, location.name FROM location
INNER JOIN traverses ON traverses.lid = location.id
INNER JOIN quest ON quest.id = traverses.qid
WHERE quest.id = [current quest];

-- View Enemies by Locations
SELECT enemy.name, health, defense, magic_defense FROM enemy
INNER JOIN location ON location.id = enemy.lid
WHERE location.id = [current location];

-- View Boss by Quest
SELECT enemy.name, health, defense, magic_defense FROM enemy
INNER JOIN bosses ON bosses.enid = enemy.id
INNER JOIN quest ON quest.id = bosses.qid
WHERE quest.id = [current quest];

-- View Enemies
SELECT name, lid, health, defense, magic_defense, tech_value FROM enemy


-- View Locations
SELECT name, eid FROM location


-- Add Enemy
INSERT INTO enemy(name, lid, health, defense, magic_defense, tech_value) 
VALUES ([typed name],[typed number] ,[typed number] ,[typed number] ,[typed number] ,[typed number] )


-- Add Location
INSERT INTO location(name, eid) VALUES ([typed name],[typed number] )


-- Delete Enemy
DELETE from enemy WHERE name=[typed name]


-- Delete Location
DELETE from location WHERE name=[typed name]


-- Update Enemy
UPDATE enemy SET lid=[typed number], health=[typed number], defense=[typed number], magic_defense=[typed number], tech_value=[typed number] WHERE name=[typed name]


-- Update Location
UPDATE location SET eid=[typed number]  WHERE name=[typed name]