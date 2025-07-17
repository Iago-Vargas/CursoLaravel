export type TransactionResponse = {
    create_at?: string;
    id: number;
    user_id?: number;
    transaction_name: string;
    transaction_date: string;
    transaction_category: string;
    transaction_amount: number;
    transaction_type: string;
    update_at?: string;
}