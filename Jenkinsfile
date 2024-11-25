pipeline {
    agent any

    stages {
        stage('Checkout Code') {
            steps {
                // Récupérer le code source depuis le dépôt Git
                checkout scm
            }
        }

         stage ('Run Docker Compose') {
            steps{
                sh 'sudo docker-compose up -d'
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
