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


bool type_equals( struct type *a, struct type *b )
{
    if( a->kind == b->kind ) {
        if(a->kind == TYPE_VOID || a->kind == TYPE_BOOLEAN || a->kind == TYPE_CHARACTER 
            || a->kind == TYPE_INTEGER || a->kind == TYPE_STRING){
            return true;
        } else if (a->kind == TYPE_ARRAY) {
            return type_equals(a->subtype, b->subtype);
        } else if (a->kind == TYPE_FUNCTION) {
            return type_equals(a->subtype, b->subtype) && param_list_equals(a->params, b->params);
        }
    } else {
        return false;
    } 
}

struct type * type_copy( struct type *t )
{
    if (t) {
        struct type* copy = malloc(sizeof(struct type));
        copy->kind = t->kind;
        copy->subtype = type_copy(t->subtype);
        copy->params = param_list_copy(t->params);
        return copy;
    }
    else {
        return NULL;
    }
}

void type_delete( struct type *t )
{
    if (t) {
        type_delete(t->subtype);
        param_list_delete(t->params);
        free(t);
    }
}