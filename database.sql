-- Création de la table properties
CREATE TABLE IF NOT EXISTS `properties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `address` varchar(255) NOT NULL,
  `property_type` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `area_sqft` int(11) NOT NULL,
  `bedrooms` int(11) NOT NULL,
  `bathrooms` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertion de données de test (6 annonces pour remplir la page)
INSERT INTO `properties` (`title`, `price`, `address`, `property_type`, `status`, `area_sqft`, `bedrooms`, `bathrooms`, `image_url`) VALUES
('Appartement Moderne Centre-Ville', 150000.00, 'Avenue Habib Bourguiba, Tunis', 'Appartment', 'For Sell', 1200, 3, 2, 'img/property-1.jpg'),
('Villa de Luxe avec Piscine', 1500.00, 'Les Berges du Lac, Tunis', 'Villa', 'For Rent', 3500, 5, 4, 'img/property-2.jpg'),
('Espace Bureau Open Space', 250000.00, 'Centre Urbain Nord, Tunis', 'Office', 'For Sell', 800, 0, 1, 'img/property-3.jpg'),
('Immeuble Résidentiel', 1000.00, 'La Marsa, Tunis', 'Building', 'For Rent', 5000, 10, 8, 'img/property-4.jpg'),
('Maison Traditionnelle', 800000.00, 'Sidi Bou Said, Tunis', 'Home', 'For Sell', 1500, 3, 2, 'img/property-5.jpg'),
('Local Commercial', 600.00, 'Menzah 5, Tunis', 'Shop', 'For Rent', 500, 0, 1, 'img/property-6.jpg');
-- Nouvelles données de test (12 annonces supplémentaires)

INSERT INTO `properties` 
(`title`, `price`, `address`, `property_type`, `status`, `area_sqft`, `bedrooms`, `bathrooms`, `image_url`) VALUES

('Studio Vue Mer', 220000.00, 'La Goulette, Tunis', 'Appartment', 'For Sell', 600, 1, 1, 'img/property-7.jpg'),
('Penthouse Luxe Panoramique', 950000.00, 'Les Berges du Lac 2, Tunis', 'Appartment', 'For Sell', 2800, 4, 3, 'img/property-8.jpg'),
('Bureau Moderne Équipé', 1200.00, 'Charguia 1, Tunis', 'Office', 'For Rent', 900, 0, 2, 'img/property-9.jpg'),
('Villa Familiale Jardin', 700000.00, 'Ariana, Tunis', 'Villa', 'For Sell', 3200, 4, 3, 'img/property-10.jpg'),
('Maison de Campagne', 450000.00, 'Bizerte, Tunisie', 'Home', 'For Sell', 2000, 3, 2, 'img/property-11.jpg'),
('Local Commercial Centre', 900.00, 'Centre Ville, Sfax', 'Shop', 'For Rent', 650, 0, 1, 'img/property-12.jpg'),
('Appartement Économique', 350.00, 'Ezzahra, Tunis', 'Appartment', 'For Rent', 750, 2, 1, 'img/property-13.jpg'),
('Villa avec Jardin et Garage', 880000.00, 'Carthage, Tunis', 'Villa', 'For Sell', 4000, 5, 4, 'img/property-14.jpg'),
('Open Space Startup', 1800.00, 'Technopole El Ghazala, Ariana', 'Office', 'For Rent', 1100, 0, 2, 'img/property-15.jpg'),
('Maison Moderne Minimaliste', 620000.00, 'Nabeul, Tunisie', 'Home', 'For Sell', 1700, 3, 2, 'img/property-16.jpg'),
('Boutique Commerciale', 1100.00, 'Sousse Centre', 'Shop', 'For Rent', 550, 0, 1, 'img/property-17.jpg'),
('Résidence Haut Standing', 1200000.00, 'Gammarth, Tunis', 'Building', 'For Sell', 6000, 12, 10, 'img/property-18.jpg');