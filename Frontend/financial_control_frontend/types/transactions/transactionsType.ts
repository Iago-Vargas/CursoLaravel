export type transactionsType = {
    id: number, 
    user_id?: number,
    transaction_name: string,
    transaction_date: string,
    transaction_category: string,
    transaction_amount: number | undefined,
    transaction_type: string,
};