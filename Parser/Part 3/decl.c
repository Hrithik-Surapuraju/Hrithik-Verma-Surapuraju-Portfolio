#include "decl.h"

struct decl * decl_create( char *name, struct type *type, struct expr *value, struct stmt *code, struct decl *next ) {
    struct decl* d = malloc(sizeof(*d));
    d->name = name;
    d->type = type;
    d->value = value;
    d->code = code;
    d->next = next;
    return d;
}

void decl_print(struct decl *d, int indent) {
    if (!d) return;

    printf("%s: ", d->name);
    type_print(d->type);

    if (d->value) {
        if (d->type->kind == TYPE_ARRAY) {
            // needs modification
            printf(" = {}");
        }
        else {
            printf(" = ");
            expr_print(d->value);
        }
    }

    if (d->type->kind == TYPE_FUNCTION) {
        if (d->code) {
            printf(" = {");
            stmt_print(d->code, indent + 1);
            printf("}");
        }
    }
    
    printf(";\n");
    decl_print(d->next, indent);
}
