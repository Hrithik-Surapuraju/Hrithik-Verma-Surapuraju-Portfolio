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

// taken from textbook
void decl_resolve( struct decl *d ) {
    if(!d) return;

    symbol_t kind = scope_level() > 1 ? SYMBOL_LOCAL : SYMBOL_GLOBAL;
    d->symbol = symbol_create(kind,d->type,d->name);
    expr_resolve(d->value);
    scope_bind(d->name,d->symbol);
    
    if(d->code) {
        scope_enter();
        param_list_resolve(d->type->params);
        stmt_resolve(d->code);
        scope_exit();
    }
    
    decl_resolve(d->next);
}

// taken from textbook
void decl_typecheck( struct decl *d ) {
    if(d->value) {
        struct type *t;
        t = expr_typecheck(d->value);
        if(!type_equals(t,d->symbol->type)) {
            printf("error........\n");
        }
    }
    if(d->code) {
        stmt_typecheck(d->code);
    }
}
