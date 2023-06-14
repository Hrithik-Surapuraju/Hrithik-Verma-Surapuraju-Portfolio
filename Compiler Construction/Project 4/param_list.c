#include "param_list.h"

struct param_list *param_list_create(char* name, struct type *type, struct param_list *next) {
    struct param_list* pl = malloc(sizeof(*pl));
    pl->name = name;
    pl->type = type;
    pl->next = next;
    return pl;
}

void param_list_print(struct param_list *p) {
    if (!p) return;

    printf("%s: ", p->name);
    type_print(p->type);

    if (p->next != NULL) {
        printf(", ");
        param_list_print(p->next);
    }
}
