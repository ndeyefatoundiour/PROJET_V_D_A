
CREATE TABLE role (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
);

INSERT INTO role (nom) VALUES
('ADMIN'),
('CHARGE_VENTE'),
('CHARGE_STOCK'),
('INVENTAIRE');


CREATE TABLE utilisateur (
    id SERIAL PRIMARY KEY,
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

INSERT INTO utilisateur
(nom, prenom, email, password, adresse, telephone, role_id)
VALUES
('Boutique', 'Admin', 'admin@storemanager.sn', 'demo1234', 'Dakar', '770000001', 1),
('Vente', 'Charge', 'vente@storemanager.sn', 'demo1234', 'Dakar', '770000002', 2),
('Stock', 'Charge', 'stock@storemanager.sn', 'demo1234', 'Dakar', '770000003', 3),
('Inventaire', 'Agent', 'inventaire@storemanager.sn', 'demo1234', 'Dakar', '770000004', 4);



CREATE TABLE client (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(30),
    email VARCHAR(150)
);

INSERT INTO client
(nom, prenom, telephone, email)
VALUES
('Ndiaye', 'Moussa', '771111111', 'moussa@gmail.com'),
('Diop', 'Awa', '772222222', 'awa@gmail.com'),
('Fall', 'Ibrahima', '773333333', 'ibrahima@gmail.com'),
('Sow', 'Fatou', '774444444', 'fatou@gmail.com'),
('Ba', 'Oumar', '775555555', 'oumar@gmail.com');


CREATE TABLE fournisseur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    email VARCHAR(150),
    telephone VARCHAR(30),
    adresse VARCHAR(255)
);

INSERT INTO fournisseur
(nom, email, telephone, adresse)
VALUES
('Fournisseur Dakar Distribution', 'contact@dakardistribution.sn', '761111111', 'Dakar'),
('Senegal Market', 'contact@senegalmarket.sn', '762222222', 'Dakar'),
('Global Commerce', 'contact@globalcommerce.sn', '763333333', 'Thiès');

CREATE TABLE produit (
    id SERIAL PRIMARY KEY,
    code VARCHAR(100) NOT NULL UNIQUE,
    libelle VARCHAR(150) NOT NULL,
    prix_vente NUMERIC(12,2) NOT NULL,
    cout_achat NUMERIC(12,2) NOT NULL,
    stock_initial INT NOT NULL DEFAULT 0,
    stock_actuel INT NOT NULL DEFAULT 0,
    seuil_alerte INT NOT NULL DEFAULT 0
);

INSERT INTO produit
(code, libelle, prix_vente, cout_achat, stock_initial, stock_actuel, seuil_alerte)
VALUES
('P001', 'Ordinateur Portable', 350000, 280000, 10, 10, 3),
('P002', 'Souris Sans Fil', 10000, 6000, 30, 30, 5),
('P003', 'Clavier USB', 15000, 9000, 20, 20, 5),
('P004', 'Casque Bluetooth', 25000, 15000, 15, 15, 3),
('P005', 'Disque SSD 512GB', 45000, 30000, 12, 12, 3),
('P006', 'Clé USB 64GB', 8000, 5000, 25, 25, 5);

CREATE TABLE mode_paiement (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

INSERT INTO mode_paiement (nom) VALUES
('ESPECES'),
('WAVE'),
('ORANGE MONEY'),
('CARTE BANCAIRE'),
('CHEQUE');

CREATE TABLE commande (
    id SERIAL PRIMARY KEY,
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

INSERT INTO commande
(numero_facture, montant_total, montant_verse, mode_reglement, statut, date_vente, date_echeance, utilisateur_id, client_id)
VALUES
('FAC-2026-001', 360000, 360000, 'ESPECES', 'PAYEE', '2026-08-10', NULL, 2, 1),

('FAC-2026-002', 25000, 15000, 'WAVE', 'PARTIELLE', '2026-08-11', '2026-08-20', 2, 2),

('FAC-2026-003', 55000, 0, 'ORANGE MONEY', 'NON_PAYEE', '2026-08-12', '2026-08-22', 2, 3),

('FAC-2026-004', 45000, 45000, 'ESPECES', 'PAYEE', '2026-08-13', NULL, 1, 4);

CREATE TABLE ligne_commande (
    id SERIAL PRIMARY KEY,
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

INSERT INTO ligne_commande
(quantite, prix_unitaire, sous_total, commande_id, produit_id)
VALUES
(1, 350000, 350000, 1, 1),
(1, 10000, 10000, 1, 2),

(1, 25000, 25000, 2, 4),

(1, 45000, 45000, 3, 5),
(1, 10000, 10000, 3, 2),

(1, 45000, 45000, 4, 5);

CREATE TABLE dette (
    id SERIAL PRIMARY KEY,
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

INSERT INTO dette
(ref, montant_initial, montant_verse, montant_restant, date_echeance, statut, client_id, commande_id)
VALUES
('DET-2026-001', 25000, 15000, 10000, '2026-08-20', 'PARTIELLE', 2, 2),

('DET-2026-002', 55000, 0, 55000, '2026-08-22', 'NON_PAYEE', 3, 3);

CREATE TABLE paiement (
    id SERIAL PRIMARY KEY,
    montant NUMERIC(12,2) NOT NULL,
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

INSERT INTO paiement
(montant, date_paiement, reference, dette_id, mode_paiement_id, utilisateur_id)
VALUES
(5000, '2026-08-12', 'PAY-2026-002', 1, 1, 2),
(3000, '2026-08-13', 'PAY-2026-003', 1, 3, 1),
(2000, '2026-08-14', 'PAY-2026-004', 1, 2, 2),

(10000, '2026-08-13', 'PAY-2026-005', 2, 1, 2),
(15000, '2026-08-14', 'PAY-2026-006', 2, 2, 1),
(5000, '2026-08-15', 'PAY-2026-007', 2, 3, 2);

CREATE TABLE approvisionnement (
    id SERIAL PRIMARY KEY,
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

INSERT INTO approvisionnement
(reference_bl, cout_total, date_appro, date_reception, statut, fournisseur_id, utilisateur_id)
VALUES
('BL-2026-001', 280000, '2026-08-05', '2026-08-05', 'RECU', 1, 3),

('BL-2026-002', 150000, '2026-08-08', '2026-08-08', 'RECU', 2, 3),

('BL-2026-003', 300000, '2026-08-14', NULL, 'EN_ATTENTE', 3, 3);

CREATE TABLE ligne_approvisionnement (
    id SERIAL PRIMARY KEY,
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

INSERT INTO ligne_approvisionnement
(quantite_appro, quantite_recue, prix_achat, sous_total, approvisionnement_id, produit_id)
VALUES
(10, 10, 280000, 2800000, 1, 1),

(20, 20, 6000, 120000, 2, 2),

(10, 10, 9000, 90000, 2, 3),

(10, 0, 30000, 300000, 3, 5);