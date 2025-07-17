export type UserRegister = {
    name: string;
    email: string;
    updated_at: string;
    created_at: string;
    id: number;
};
export type Token = {
    accessToken: string;
    abilities: string[];
    created_at: string;
    expires_at: string | null;
    name: string;
    tokenable_id: number;
    tokenable_type: string;
    updated_at: string;
    plainTextToken: string;
}
export type RegisterResponse = {
    userRegistred: UserRegister;
    token: Token;
};