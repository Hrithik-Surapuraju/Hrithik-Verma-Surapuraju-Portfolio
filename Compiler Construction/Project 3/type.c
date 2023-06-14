#include "type.h"

struct type *type_create(type_t kind, struct type *subtype, struct param_list *params) {
    struct type* t = malloc(sizeof(*t));
    t->kind = kind;
    t->subtype = subtype;
    t->params = params;
    return t;
}

void type_print(struct type *t) {
    if (!t) return;
    switch(t->kind) {
        case TYPE_VOID:
            printf("void");
            break;
        case TYPE_BOOLEAN:
            printf("boolean");
            break;
        case TYPE_CHARACTER:
            printf("char");
            break;
        case TYPE_INTEGER:
            printf("int");
            break;
        case TYPE_STRING:
            printf("string");
            break;
        case TYPE_ARRAY:
            printf("array []");
            type_print(t->subtype);
            break;
        case TYPE_FUNCTION:
            printf("function ");
            if (t->subtype) {
                type_print(t->subtype);
            }
            printf(" (");
            param_list_print(t->params);
            printf(") ");
            break;
    }
}
