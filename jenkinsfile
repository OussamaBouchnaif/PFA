pipeline {
    agent any

    environment {
        // Définir une variable d'environnement pour le fichier docker-compose
        DOCKER_COMPOSE_FILE = './docker-compose.yml'
    }

    stages {
        stage('Checkout Code') {
            steps {
                // Récupérer le code source depuis le dépôt Git
                script {
                    echo 'Clonage du dépôt Git...'
                }
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                // Construire l'image Docker
                script {
                    echo 'Construction de l’image Docker...'
                }
                sh 'docker-compose up -d'
            }
        }

        stage('Run Tests') {
            steps {
                // Lancer les tests PHPUnit
                script {
                    echo 'Exécution des tests PHPUnit...'
                }
                sh 'docker exec client vendor/bin/phpunit'
            }
        }
    }

    post {
        always {
            echo 'Pipeline terminé.'
        }
        success {
            echo 'Tests exécutés avec succès !'
        }
        failure {
            echo 'Des tests ont échoué.'
        }
    }
}