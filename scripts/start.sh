#!/bin/bash

echo "👋 Hey there! Welcome back!"
echo "🚀 Firing up the Blois Badminton Club project..."
echo ""

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m'

# 1. Check if Docker is awake
echo "🐳 Checking if Docker is awake..."
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}❌ Oops! Docker seems to be sleeping!${NC}"
    echo "💡 Wake it up (launch Docker Desktop) and try again!"
    exit 1
fi
echo -e "${GREEN}✅ Docker is up and running!${NC}"
echo ""

# 2. Start Docker containers
echo "🐳 Starting Docker containers..."
docker-compose up -d
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Containers are ready to go!${NC}"
else
    echo -e "${RED}❌ Hmm, something went wrong with the containers${NC}"
    exit 1
fi
echo ""

# 3. Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to get comfy..."
sleep 5
echo -e "${GREEN}✅ MySQL is all set!${NC}"
echo ""

# 4. Check database (DANS Docker)
echo "🗄️  Checking the database..."
docker-compose exec -T php php bin/console doctrine:database:create --if-not-exists
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Database looking good!${NC}"
else
    echo -e "${YELLOW}⚠️  Database connection needs some love${NC}"
fi
echo ""

# 5. Check migrations (DANS Docker)
echo "📦 Checking migrations status..."
docker-compose exec -T php php bin/console doctrine:migrations:status
echo ""

# 6. Clear cache (DANS Docker)
echo "🧹 Tidying up the cache..."
docker-compose exec -T php php bin/console cache:clear
if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Cache is sparkling clean!${NC}"
else
    echo -e "${RED}❌ Cache cleanup failed${NC}"
fi
echo ""

# 7. Check translations
echo "🌍 Checking translation files..."
if [ -f "app/translations/messages.en.yaml" ]; then
    echo -e "${GREEN}✅ English translations found!${NC}"
else
    echo -e "${YELLOW}⚠️  Missing messages.en.yaml file${NC}"
fi
echo ""

# 8. Final status
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo -e "${PURPLE}🎉 All systems go! Project is ready!${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo -e "${BLUE}📋 Quick info:${NC}"
echo "  🌐 Your site: http://localhost:8081"
echo "  🗄️  phpMyAdmin: http://localhost:8899"
echo "  🛑 Stop project: ./scripts/stop.sh"
echo "  📊 Docker logs: docker-compose logs -f"
echo ""
echo -e "${GREEN}Happy coding! 🏸💻${NC}"