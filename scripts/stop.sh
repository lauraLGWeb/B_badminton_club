#!/bin/bash

echo "👋 Time to wrap up!"
echo "🛑 Shutting down the Blois Badminton Club project..."
echo ""

GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

# Stop Docker containers
echo "🐳 Stopping Docker containers..."
docker-compose stop
echo -e "${GREEN}✅ Docker containers stopped${NC}"
echo ""

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo -e "${BLUE}✨ Project successfully stopped!${NC}"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo -e "${GREEN}See you next time! 🏸👋${NC}"