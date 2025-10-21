pipeline {
    agent any

    environment {
        COMPOSE_PROJECT_NAME = 'affilab-deployment'
        AWS_ACCESS_KEY_ID=credentials('AWS_ACCESS_KEY_ID')
        AWS_SECRET_ACCESS_KEY=credentials('AWS_SECRET_ACCESS_KEY')
        AFFILAB_SUPABASE_DB_URL=credentials('AFFILAB_SUPABASE_DB_URL')
        AFFILAB_N8N_WEBHOOK_URL=credentials('AFFILAB_N8N_WEBHOOK_URL')
    }

    stages {
        stage('Clean Previous') {
            steps {
                sh '''
                    # Remove containers
                    docker compose down
                    
                    # Remove project images
                    docker images -q ${COMPOSE_PROJECT_NAME}* | xargs -r docker rmi -f
                    
                    # Clean network
                    docker network rm affilab-network || true
                '''
            }
        }

        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Build') {
            steps {
                sh 'docker compose build'
            }
        }

        stage('Deploy') {
            steps {
                withCredentials([
                string(credentialsId: 'AWS_ACCESS_KEY_ID', variable: 'AWS_ACCESS_KEY_ID'),
                string(credentialsId: 'AWS_SECRET_ACCESS_KEY', variable: 'AWS_SECRET_ACCESS_KEY'),
                string(credentialsId: 'AFFILAB_SUPABASE_DB_URL', variable: 'AFFILAB_SUPABASE_DB_URL')
                string(credentialsId: 'AFFILAB_N8N_WEBHOOK_URL', variable: 'AFFILAB_N8N_WEBHOOK_URL')
      
                ]) 
                    {
                    sh """
                        docker compose up -d
                        
                        # Wait container ready
                        sleep 10
                        
                        # Run migration and setup Laravel
                        docker compose exec -T app cp .env.example .env
                        docker compose exec -T app php artisan key:generate

                        # Inject secrets
                        echo "AWS_ACCESS_KEY_ID=\$AWS_ACCESS_KEY_ID"
            
                        docker compose exec -T app sh -c 'sed -i "s|^AWS_ACCESS_KEY_ID=.*|AWS_ACCESS_KEY_ID=${AWS_ACCESS_KEY_ID}|" .env'
                        docker compose exec -T app sh -c 'sed -i "s|^AWS_SECRET_ACCESS_KEY=.*|AWS_SECRET_ACCESS_KEY=${AWS_SECRET_ACCESS_KEY}|" .env'
                        docker compose exec -T app sh -c 'sed -i "s|^DB_URL=.*|DB_URL=${AFFILAB_SUPABASE_DB_URL}|" .env'
                        docker compose exec -T app sh -c 'sed -i "s|^N8N_WEBHOOK_URL=.*|N8N_WEBHOOK_URL=${AFFILAB_N8N_WEBHOOK_URL}|" .env'

                        # docker compose exec -T app php artisan webpush:vapid
                        
                        # docker compose exec -T app php artisan migrate --seed
                        
                        docker compose exec -T app php artisan optimize:clear
                        docker compose exec -T app php artisan optimize

                        docker compose exec -T app npm run build

                        # docker compose exec -T app php artisan queue:work --sleep=3 &


                    """
                }
            }
        }
    }

    post {
        always {
            sh 'docker compose ps'
            cleanWs()
        }
    }
}