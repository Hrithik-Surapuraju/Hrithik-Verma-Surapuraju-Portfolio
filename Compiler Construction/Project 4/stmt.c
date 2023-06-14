#include "stmt.h"

struct stmt* stmt_create(stmt_t kind, struct decl *decl, struct expr *init_expr, struct expr *expr, struct expr *next_expr, struct stmt *body, struct stmt *else_body, struct stmt *next ) {
    struct stmt* s = malloc(sizeof(*s));
    s->kind = kind;
    s->decl = decl;
    s->init_expr = init_expr;
    s->expr = expr;
    s->next_expr = next_expr;
    s->body = body;
    s->else_body = else_body;
    s->next = next;
    return s;
}


void stmt_print( struct stmt *s, int level ){
    if (s == NULL) return;
    
    if (level > 1) {
        for (int i = 1; i < level; ++i) {
            printf("\t");
        }
    }
    
    switch(s->kind) {
        case STMT_DECL:
            decl_print(s->decl, level);
            printf(";\n");
            break;
        case STMT_EXPR:
            expr_print(s->expr, level);
            printf(";\n");
            break;
        case STMT_IF_ELSE:
            printf("if ( ");
            expr_print(s->expr, level);
            printf(" ) {\n");
            stmt_print(s->body, level+1);
            if (s->else_body == NULL) {
                printf("}\n");
            } 
            else {
                printf("} else {\n");
                stmt_print(s->else_body, level+1);
                printf("}\n");
            }
            break;
        case STMT_FOR:
            printf("for (");
            expr_print(s->init_expr, level);
            printf("; ");
            expr_print(s->expr, level);
            printf("; ");
            expr_print(s->next_expr, level);
            printf(") {\n");
            expr_print(s->body, level+1);
            printf("}\n");
            break;
        case STMT_PRINT:
            printf("print ");
            expr_print(s->expr, level);
            printf(";\n");
            break;
        case STMT_RETURN:
            printf("return ");
            expr_print(s->expr, level);
            printf(";\n");
            break;
        case STMT_BLOCK:
            stmt_print(s->body, level);
            break;
    }

    if (s->next) {
        stmt_print(s->next, level);
    }
}
