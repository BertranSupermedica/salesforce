# MÉTODO ALTERNATIVO: Oracle via Docker (se instalação manual falhar)

# === Se a instalação manual do Oracle não funcionar ===

# 1. Instalar Docker (se não tiver)
sudo apt update
sudo apt install -y docker.io docker-compose
sudo systemctl start docker
sudo usermod -aG docker $USER

# 2. Criar container Oracle Express
docker run -d \
  --name oracle-xe \
  -p 1521:1521 \
  -p 8080:8080 \
  -e ORACLE_PWD=password123 \
  container-registry.oracle.com/database/express:latest

# 3. Aguardar Oracle inicializar (pode demorar 5-10 min)
docker logs -f oracle-xe

# 4. Usar PDO ao invés de OCI8 no Laravel
# Editar config/database.php para usar pdo_oci ao invés de oci8

# 5. Configurar .env para Docker Oracle
DB_CONNECTION=oracle
DB_HOST=localhost
DB_PORT=1521
DB_DATABASE=XE
DB_USERNAME=system
DB_PASSWORD=password123

# === VANTAGENS DO DOCKER ===
# - Mais fácil de instalar
# - Versão Oracle sempre atualizada
# - Não conflita com sistema
# - Fácil de remover/reinstalar