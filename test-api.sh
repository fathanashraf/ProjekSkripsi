#!/bin/bash

BASE_URL="http://127.0.0.1:8000"
EMAIL="admin@himanikka.com"
PASSWORD="password"

echo "============================================"
echo "  HIMANIKKA API - Automated Test"
echo "============================================"
echo ""

# 1. Test API
echo "--------------------------------------------"
echo "1️⃣  TEST API (GET /api/test)"
echo "--------------------------------------------"
curl -s "$BASE_URL/api/test" | python -m json.tool
echo ""
echo ""

# 2. Login
echo "--------------------------------------------"
echo "2️⃣  LOGIN (POST /api/login)"
echo "--------------------------------------------"
LOGIN_RESPONSE=$(curl -s -X POST "$BASE_URL/api/login" \
  -H "Content-Type: application/json" \
  -d "{\"email\":\"$EMAIL\",\"password\":\"$PASSWORD\"}")
echo "$LOGIN_RESPONSE" | python -m json.tool

TOKEN=$(echo "$LOGIN_RESPONSE" | python -c "import sys,json; print(json.load(sys.stdin).get('token',''))" 2>/dev/null)

if [ -z "$TOKEN" ]; then
  echo "❌ Login gagal! Tidak bisa melanjutkan test."
  exit 1
fi
echo "✅ Token: ${TOKEN:0:20}..."
echo ""
echo ""

# 3. Get User
echo "--------------------------------------------"
echo "3️⃣  GET USER (GET /api/user)"
echo "--------------------------------------------"
curl -s "$BASE_URL/api/user" \
  -H "Authorization: Bearer $TOKEN" | python -m json.tool
echo ""
echo ""

# 4. Payment Status
echo "--------------------------------------------"
echo "4️⃣  PAYMENT STATUS (GET /api/payment/status/1)"
echo "--------------------------------------------"
curl -s "$BASE_URL/api/payment/status/1" \
  -H "Authorization: Bearer $TOKEN" | python -m json.tool
echo ""
echo ""

# 5. Logout
echo "--------------------------------------------"
echo "5️⃣  LOGOUT (POST /api/logout)"
echo "--------------------------------------------"
curl -s -X POST "$BASE_URL/api/logout" \
  -H "Authorization: Bearer $TOKEN" | python -m json.tool
echo ""
echo ""

# 6. Test Unauthorized (should return 401)
echo "--------------------------------------------"
echo "6️⃣  TEST UNAUTHORIZED (GET /api/user tanpa token)"
echo "--------------------------------------------"
curl -s -w "\nHTTP Status: %{http_code}\n" "$BASE_URL/api/user"
echo ""
echo ""

echo "============================================"
echo "  ✅ Test Selesai!"
echo "============================================"
