#include "scope.h"

stack* s = stack_create();

void scope_enter() {
    ht* new_ht = ht_create();
    stack_push(s, new_ht);
}

void scope_exit() {
    ht* deleted_ht = (ht*)stack_pop(s);
    ht_destroy(deleted_ht);
}

int scope_level() {
    return stack_size(s);
}

void scope_bind(const char* name, struct symbol* sym) {
    ht* top_ht = (ht*)stack_item(s, stack_size(s) - 1);
    char* key = ht_set(top_ht, name, sym);
    
    if (key != NULL) {
        stack_push(s, top_ht);
    }
    else {
        printf("Hash table out of memory.\n");
    }
}

struct symbol* scope_lookup(const char* name) {
    struct symbol* value = NULL;
    for (int i = stack_size(s); i >= 0; i--) {
        ht* table = (ht*)stack_item(s, i);
        value = ht_get(table, name);
    }
    return value;
}

struct symbol* scope_lookup_current(const char* name) {
    struct symbol* value = ht_get((ht*)stack_item(stack_size(s) - 1), name);
    return value;
}
