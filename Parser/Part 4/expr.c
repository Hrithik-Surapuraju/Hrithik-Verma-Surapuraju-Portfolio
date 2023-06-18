#include "expr.h"

struct expr *expr_create(expr_t kind, struct expr *left, struct expr *right) {
    struct expr* e = malloc(sizeof(*e));
    e->kind = kind;
    e->left = left;
    e->right = right;
    return e;
}

struct expr * expr_create_name(const char *name){
    struct expr* e = expr_create(EXPR_NAME, 0, 0);
    e->name = name;
    return e;
}

struct expr * expr_create_integer_literal(int i){
    struct expr* e = expr_create(EXPR_INTEGER_LITERAL, 0, 0);
    e->integer_value = i;
    return e;
}

struct expr * expr_create_boolean_literal(int b){
    struct expr* e = expr_create(EXPR_BOOL_LITERAL, 0, 0);
    e->integer_value = b;
    return e;
}

struct expr * expr_create_char_literal(char c){
    struct expr* e = expr_create(EXPR_CHAR_LITERAL, 0, 0);
    e->integer_value = c;
    return e;
}

struct expr * expr_create_string_literal(const char *str){
    struct expr* e = expr_create(EXPR_STRING_LITERAL, 0, 0);
    e->string_literal = str;
    return e;
}

void expr_print(struct expr *e) {
    if (!e) return;

    // more cases to be added as more values are added in expr_t enum type
    switch(e->kind) {
        case EXPR_ADD:
            expr_print(e->left);
            printf(" + ");
            expr_print(e->right);
            break;
        case EXPR_SUB:
            expr_print(e->left);
            printf(" - ");
            expr_print(e->right);
            break;
        case EXPR_MUL:
            expr_print(e->left);
            printf(" * ");
            expr_print(e->right);
            break;
        case EXPR_DIV:
            expr_print(e->left);
            printf(" / ");
            expr_print(e->right);
            break;
        case EXPR_NAME:
            printf("%s", e->name);
            break;
        case EXPR_INTEGER_LITERAL:
            printf("%d", e->integer_value);
            break;
        case EXPR_CHAR_LITERAL:
            printf("'%c'", e->integer_value);
            break;
        case EXPR_BOOL_LITERAL:
            if (e->integer_value == 0) {
                printf("false");
            }
            else if (e->integer_value == 1) {
                printf("true");
            }
            break;
        case EXPR_STRING_LITERAL:
            printf("%s", e->string_literal);
            break;
    }
}

// taken from textbook
void expr_resolve(struct expr *e) {
    if(!e) return;

    if( e->kind==EXPR_NAME ) {
        e->symbol = scope_lookup(e->name);
    } 
    else {
        expr_resolve( e->left );
        expr_resolve( e->right );
    }
}
