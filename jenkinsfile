pipeline {
    agent any

    stages {
        stage('Checkout Code') {
            steps {
                // Récupérer le code source depuis le dépôt Git
                checkout scm
            }
        }

        stage('Build Docker Image') {
            steps {
                // Construire l'image Docker
                sh 'docker-compose build'
            }
        }

        stage('Run Tests') {
            steps {
                // Lancer les tests PHPUnit
                sh 'docker-compose run tests'
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
