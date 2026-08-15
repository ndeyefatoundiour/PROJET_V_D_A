PRAGMA foreign_keys = ON;

CREATE TABLE role (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL
);



CREATE TABLE utilisateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    adresse VARCHAR(100),
    telephone VARCHAR(20),
    role_id INT NOT NULL,

    CONSTRAINT fk_utilisateur_role
        FOREIGN KEY (role_id)
        REFERENCES role(id)
);



CREATE TABLE client (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(30),
    email VARCHAR(150)
);



CREATE TABLE fournisseur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    telephone VARCHAR(30),
    adresse VARCHAR(255)
);


CREATE TABLE produit (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(100) NOT NULL UNIQUE,
    libelle VARCHAR(150) NOT NULL,
    categorie VARCHAR(100),
    prix_vente NUMERIC(12,2) NOT NULL,
    cout_achat NUMERIC(12,2) NOT NULL,
    stock_initial INT NOT NULL DEFAULT 0,
    stock_actuel INT NOT NULL DEFAULT 0,
    seuil_alerte INT NOT NULL DEFAULT 0
);



CREATE TABLE mode_paiement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(100) NOT NULL UNIQUE
);



CREATE TABLE commande (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_facture VARCHAR(100) NOT NULL UNIQUE,
    montant_total NUMERIC(12,2) NOT NULL DEFAULT 0,
    montant_verse NUMERIC(12,2) NOT NULL DEFAULT 0,
    mode_reglement VARCHAR(100),
    statut VARCHAR(50) NOT NULL DEFAULT 'EN_ATTENTE',
    date_vente DATE NOT NULL DEFAULT CURRENT_DATE,
    date_echeance DATE,

    utilisateur_id INT NOT NULL,
    client_id INT,

    CONSTRAINT fk_commande_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id),

    CONSTRAINT fk_commande_client
        FOREIGN KEY (client_id)
        REFERENCES client(id)
);



CREATE TABLE ligne_commande (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    quantite INT NOT NULL,
    prix_unitaire NUMERIC(12,2) NOT NULL,
    sous_total NUMERIC(12,2) NOT NULL,

    commande_id INT NOT NULL,
    produit_id INT NOT NULL,

    CONSTRAINT fk_ligne_commande_commande
        FOREIGN KEY (commande_id)
        REFERENCES commande(id),

    CONSTRAINT fk_ligne_commande_produit
        FOREIGN KEY (produit_id)
        REFERENCES produit(id)
);



CREATE TABLE dette (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ref VARCHAR(100) NOT NULL UNIQUE,
    montant_initial NUMERIC(12,2) NOT NULL,
    montant_verse NUMERIC(12,2) NOT NULL DEFAULT 0,
    montant_restant NUMERIC(12,2) NOT NULL,
    date_echeance DATE,
    statut VARCHAR(50) NOT NULL DEFAULT 'NON_PAYEE',

    client_id INT NOT NULL,
    commande_id INT UNIQUE,

    CONSTRAINT fk_dette_client
        FOREIGN KEY (client_id)
        REFERENCES client(id),

    CONSTRAINT fk_dette_commande
        FOREIGN KEY (commande_id)
        REFERENCES commande(id)
);



CREATE TABLE paiement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    montant NUMERIC(12,2) NOT NULL,
    notes TEXT,
    date_paiement DATE NOT NULL DEFAULT CURRENT_DATE,
    reference VARCHAR(100) NOT NULL UNIQUE,

    dette_id INT NOT NULL,
    mode_paiement_id INT NOT NULL,
    utilisateur_id INT,

    CONSTRAINT fk_paiement_dette
        FOREIGN KEY (dette_id)
        REFERENCES dette(id),

    CONSTRAINT fk_paiement_mode_paiement
        FOREIGN KEY (mode_paiement_id)
        REFERENCES mode_paiement(id),

    CONSTRAINT fk_paiement_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
);



CREATE TABLE approvisionnement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    reference_bl VARCHAR(100) NOT NULL UNIQUE,
    cout_total NUMERIC(12,2) NOT NULL DEFAULT 0,
    date_appro DATE NOT NULL DEFAULT CURRENT_DATE,
    date_reception DATE,
    statut VARCHAR(50) NOT NULL DEFAULT 'EN_ATTENTE',

    fournisseur_id INT NOT NULL,
    utilisateur_id INT NOT NULL,

    CONSTRAINT fk_approvisionnement_fournisseur
        FOREIGN KEY (fournisseur_id)
        REFERENCES fournisseur(id),

    CONSTRAINT fk_approvisionnement_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id)
);



CREATE TABLE ligne_approvisionnement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    quantite_appro INT NOT NULL,
    quantite_recue INT NOT NULL DEFAULT 0,
    prix_achat NUMERIC(12,2) NOT NULL,
    sous_total NUMERIC(12,2) NOT NULL,

    approvisionnement_id INT NOT NULL,
    produit_id INT NOT NULL,

    CONSTRAINT fk_ligne_approvisionnement
        FOREIGN KEY (approvisionnement_id)
        REFERENCES approvisionnement(id),

    CONSTRAINT fk_ligne_approvisionnement_produit
        FOREIGN KEY (produit_id)
        REFERENCES produit(id)
);