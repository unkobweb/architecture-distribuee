# Architecture distribuée

Ce projet à pour but d'exploiter les connaissances acquises au cours de notre cursus en data science afin de réaliser un projet qui peut répondre à des enjeux de big data (acquisition/traitement/nettoyage de la donnée, visualisation des données, infrastructure scalable, etc.)

## Prérequis

Certains logiciels sont nécessaires pour l'exécution de ce programme. Voici les versions des logiciels avec lequel il a été testé :

	Spark version 3.0.3
	Docker version 20.10.11
	Docker-compose version 1.29.2

## Mise en place

En premier lieu, cloner le projet sur votre machine.
Il vous faudrat ensuite télécharger le dataset trouvable sur [Kaggle](https://www.kaggle.com/datasets/yelp-dataset/yelp-dataset?select=yelp_academic_dataset_business.json). 
*Ne sont nécessaire que les fichiers suivants : yelp_academic_dataset_business.json, yelp_academic_dataset_review.json et yelp_academic_dataset_user.json*
Une archive zip contenant uniquement ces fichiers est disponible sur [ici](https://mega.nz/folder/sh9wTagD#dXiAKjdacnbFmOOSB12dFw)

Ces fichiers JSON doivent être placés dans le répertoire `dataset` du projet.

Renommez le fichier `docker-compose.yml.example` en `docker-compose.yml`.

Pour lancer le projet, il vous suffit de lancer la commande `docker-compose up -d --build` à la racine du projet.

Une fois toute les étapes réalisées, vous pouvez accéder à l'interface web du projet sur http://localhost:8000.

## Ajout des données

Maintenant que le projet est en place, nous allons pouvoir l'abreuver de données

### Batch

Rendez vous dans le dossier yelp-api-fetch/spark et lancez la commande `spark-shell -I .\writeToMongo.scala  --packages org.mongodb.spark:mongo-spark-connector_2.12:3.0.1 --conf spark.sql.catalogImplementation=in-memory` pour charger en batch les données dans MongoDB.
*Cette opération est susceptible de durer un certain temps*

### Streaming

Il est possible de déployer des "agents" qui auront pour mission de remplir la base de donnée en s'appuyant sur l'API de Yelp.
Un exemple de configuration est fournit dans le fichier `docker-compose.yml`. Il vous suffit de décommenter le code et d'y ajouter votre clé API Yelp.
Un exemple est fournit pour la ville Nantes, mais il est possible d'en ajouter autant qque vous le désirez, vous devrez juste lui attribuer un autre PID et changer les ports d'écoutes pour qu'il correspondent au PID.

Les agents logs en permanence leur activité, vous pouvez monter un volume sur votre machine hôte pour récupérer les fichiers de logs. Un health check est également appelable sur `GET http://localhost:[PID]` pour vérifier que l'agent vous répond.