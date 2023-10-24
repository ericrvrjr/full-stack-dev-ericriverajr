export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface ITodo{
    id:number;
    description:string;
    is_complete:number;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    todos:ITodo[];
};
