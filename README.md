# BalanceHub

A fullstack financial transaction management application for recording and tracking financial transactions with real-time balance updates.

## Features

- Create and record financial transactions
- View transaction history with real-time balance updates 
- Client-side form validation
- Real-time account balance tracking

## Tech Stack
- Frontend: Vue.js
- Backend: laravel
- Styling: Tailwind CSS
- Testing: Cypress for E2E, Jest for unit tests

## API Endpoints

- `GET /ping` - Health check endpoint
- `POST /transactions` - Create new transaction
- `GET /transactions` - Retrieve all transactions
- `GET /transactions/:id` - Get transaction by ID
- `GET /accounts/:id` - Get account details and balance

## Getting Started

### Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd balancehub
```

2. Install dependencies:
```bash
npm run build
```

3. Start the development servers:
```bash
npm run start
```

### Running Tests
while the server is running run the tests

```bash
npm run test
```

## Data Structures

### Transaction
```typescript
{
  transaction_id: string;
  account_id: string;
  amount: number;
  created_at: string;
}
```

### Account
```typescript
{
  account_id: string;
  balance: number;
}
```

## Project Structure

```
balancehub/
├── backend/
│   ├── src/
│   │   ├── controllers/
│   │   ├── routes/
│   │   ├── services/
│   │   └── index.js
│   └── tests/
├── frontend/
│   ├── src/
│   │   ├── components/
│   │   ├── services/
│   │   └── App.jsx
│   └── tests/
└── cypress/
    └── e2e/
```

