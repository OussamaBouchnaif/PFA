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
                sh 'docker-compose up -d'
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
