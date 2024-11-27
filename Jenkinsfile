pipeline {
    agent any

    stages {
        stage('Verify Docker and Compose') {
            steps {
                echo 'Vérification de Docker et Docker Compose...'
                bat 'docker --version'
                bat 'docker-compose --version'
            }
        }

        stage('Run Pipeline Steps') {
            steps {
                echo 'Démarrage des services avec Docker Compose...'
                bat 'docker-compose up -d'
            }
        }

        

        stage('Run Tests') {
            steps {
                echo 'Exécution des tests unitaires avec PHPUnit...'
                bat 'docker exec client vendor/bin/phpunit'
            }
        }
    }

    post {
        always {
            echo 'Pipeline terminé.'
        }
        success {
            echo 'Pipeline exécuté avec succès !'
        }
        failure {
            echo 'Le pipeline a échoué. Veuillez vérifier les logs.'
        }
    }
}
