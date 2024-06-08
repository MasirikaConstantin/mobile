BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "expertise" (
	"id"	INTEGER COLLATE RTRIM,
	"nom"	INTEGER,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "ouvrier" (
	"id"	INTEGER,
	"nom"	TEXT,
	"postnom"	TEXT,
	"prenom"	TEXT,
	"num"	TEXT,
	"adressephysique"	TEXT,
	"adressepostale"	TEXT,
	"mdp"	TEXT,
	"email"	TEXT,
	"id_expertise"	INTEGER,
	"ville_intervention"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT),
	FOREIGN KEY("id_expertise") REFERENCES "expertise"("id")
);
CREATE TABLE IF NOT EXISTS "utilisateur" (
	"id"	INTEGER,
	"nom"	TEXT,
	"postnom"	TEXT,
	"prenom"	TEXT,
	"num"	TEXT,
	"Adresse"	TEXT,
	"email"	TEXT,
	"mdp"	TEXT,
	"type"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "ville_intervention" (
	"id"	INTEGER,
	"nom"	TEXT,
	PRIMARY KEY("id" AUTOINCREMENT)
);
INSERT INTO "ville_intervention" ("id","nom") VALUES (1,'Kinshasa'),
 (2,'Lubumbashi'),
 (3,'Goma'),
 (4,'Bukavu'),
 (5,'Mbuji-Mai');
COMMIT;
