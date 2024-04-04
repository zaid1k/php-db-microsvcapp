pipeline {
    agent any
    environment {
        IMAGE_NAME = "zaid786/java-mvn-privaterepos:php${BUILD_NUMBER}"
        DEV_server_IP = "ec2-user@35.154.109.200"
        TEST_server_IP = "ec2-user@65.0.105.94"
    }

    stages {
        stage('Build the Docker image for PHP and push to Docker Hub on DEV_server') {
            steps {
                script {
                    sshagent(['DEV_SERVER']) {
                        withCredentials([usernamePassword(credentialsId: 'docker-hub', passwordVariable: 'PASSWORD', usernameVariable: 'USERNAME')]) {
                            echo "Building the Docker image"
                            sh "scp -o StrictHostKeyChecking=no -r devserverconfig ${DEV_server_IP}:/home/ec2-user/"
                            sh "ssh -o StrictHostKeyChecking=no ${DEV_server_IP} 'bash /home/ec2-user/devserverconfig/docker-script.sh'"
                            sh "ssh ${DEV_server_IP} sudo docker build -t ${IMAGE_NAME} /home/ec2-user/devserverconfig"
                            sh "ssh ${DEV_server_IP} sudo docker login -u $USERNAME -p $PASSWORD"
                            sh "ssh ${DEV_server_IP} sudo docker push ${IMAGE_NAME}"  
                        }
                    }
                }
            }
        }
        stage('Run the php_db app on test server on TEST_SERVER') {
            steps {
                script {
                    sshagent(['TEST_server']) {
                        withCredentials([usernamePassword(credentialsId: 'docker-hub', passwordVariable: 'PASSWORD', usernameVariable: 'USERNAME')]) {
                            echo "Building the Docker image"
                            sh "scp -o StrictHostKeyChecking=no -r testserverconfig ${TEST_server_IP}:/home/ec2-user/"
                            sh "ssh -o StrictHostKeyChecking=no ${TEST_server_IP} 'bash /home/ec2-user/testserverconfig/docker-script.sh'"
                            sh "ssh ${TEST_server_IP} sudo docker login -u $USERNAME -p $PASSWORD"                            
                            sh "ssh ${TEST_server_IP} bash /home/ec2-user/testserverconfig/compose-script.sh ${IMAGE_NAME}"  
                        }
                    }
                }
            }       
        }
    }
}
