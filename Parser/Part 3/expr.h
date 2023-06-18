#ifndef EXPR_H
#define EXPR_H
#include <stdio.h>
#include <stdlib.h>

// more values to be added
typedef enum {
    EXPR_ADD,
    EXPR_SUB,
    EXPR_MUL,
    EXPR_DIV,
    EXPR_NAME,
    EXPR_INTEGER_LITERAL,
    EXPR_CHAR_LITERAL,
    EXPR_BOOL_LITERAL,
    EXPR_STRING_LITERAL
} expr_t;

struct expr {
    expr_t kind;
    struct expr* left;
    struct expr* right;
    const char* name;
    int integer_value;
    const char* string_literal;
};

struct expr *expr_create(expr_t kind, struct expr *left, struct expr *right);
struct expr * expr_create_name(const char *name);
struct expr * expr_create_integer_literal(int i);
struct expr * expr_create_boolean_literal(int b);
struct expr * expr_create_char_literal(char c);
struct expr * expr_create_string_literal(const char *str);
void expr_print(struct expr *e);


#endif