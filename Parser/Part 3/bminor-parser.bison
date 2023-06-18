%token  TOKEN_ADD
%token  TOKEN_CCOMMENT
%token  TOKEN_CPPCOMMENT
%token  TOKEN_LPAREN
%token  TOKEN_RPAREN
%token  TOKEN_LSQBRAC
%token  TOKEN_RSQBRAC
%token  TOKEN_INCREMENT
%token  TOKEN_DECREMENT
%token  TOKEN_MINUS
%token  TOKEN_LNOT
%token  TOKEN_MULT
%token  TOKEN_DIV
%token  TOKEN_MOD
%token  TOKEN_LESS
%token  TOKEN_LESSEQ
%token  TOKEN_GREAT
%token  TOKEN_GREATEQ
%token  TOKEN_EQUAL
%token  TOKEN_NOTEQ
%token  TOKEN_LAND
%token  TOKEN_LOR
%token  TOKEN_ASSIGN
%token  TOKEN_WHILE
%token  name
%token  TOKEN_NUMBER
%token  TOKEN_ARRAY
%token  TOKEN_AUTO
%token  TOKEN_BOOLEAN
%token  TOKEN_CHAR
%token  TOKEN_ELSE
%token  TOKEN_FALSE
%token  TOKEN_FOR
%token  TOKEN_FUNCTION
%token  TOKEN_IF
%token  TOKEN_INT
%token  TOKEN_PRINT
%token  TOKEN_RETURN
%token  TOKEN_STRING
%token  TOKEN_TRUE
%token  TOKEN_VOID
%token  TOKEN_COLON
%token  TOKEN_SEMICOLON
%token  TOKEN_COMMA
%token  TOKEN_LBRACE
%token  TOKEN_RBRACE
%token  TOKEN_STRVAL
%token  TOKEN_CHARVAL
%token  TOKEN_ERROR
%token  TOKEN_EXPO

%{ 

#include <stdio.h>
#include <stdlib.h>
#include "decl.h"
#include "expr.h"
#include "param_list.h"
#include "stmt.h"
#include "type.h"

extern char *yytext;
extern int yylex();
extern int yyerror( char *str );

struct decl * parser_result = 0;

%}

%union {
    struct decl *decl;
    struct stmt *stmt;
    struct expr *expr;
    struct param_list *param_list;
    struct type *type;
    char* name;
    int size;
};

%type <decl> program decl_list decl
%type <stmt> stmt_list stmt
%type <name> name

%%

/* Here is the grammar: program is the start symbol. */

program : decl_list 
            { parser_result = $1; }
        ;

decl_list : decl            { $$ = $1; }
          | decl decl_list  { $$ = $1; $1->next = $2; }
          ;

decl : name TOKEN_COLON type TOKEN_SEMICOLON     { $$ = decl_create($1, $3, 0, 0, 0); }
     | name TOKEN_COLON type TOKEN_ASSIGN expr TOKEN_SEMICOLON   { $$ = decl_create($1, $3, $4, 0, 0); }
     | name TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN param_list TOKEN_RPAREN TOKEN_SEMICOLON    
     | name TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN TOKEN_RPAREN TOKEN_SEMICOLON 
     | name TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN param_list TOKEN_RPAREN TOKEN_ASSIGN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | name TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN TOKEN_RPAREN TOKEN_ASSIGN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     ;

stmt_list : stmt stmt_list  { $$ = $1; $1->next = $2; }
          | /* epsilon */	{ $$ = 0; }
          ;

stmt : TOKEN_RETURN expr TOKEN_SEMICOLON        { $$ = stmt_create(STMT_RETURN, 0, $2, 0, 0, 0, 0, 0); }
     | TOKEN_IF TOKEN_LPAREN r_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | TOKEN_IF TOKEN_LPAREN r_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE TOKEN_ELSE TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | TOKEN_WHILE TOKEN_LPAREN r_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | TOKEN_FOR TOKEN_LPAREN name TOKEN_ASSIGN expr TOKEN_SEMICOLON r_expr TOKEN_SEMICOLON u_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE 
     | name TOKEN_LPAREN func_args TOKEN_RPAREN TOKEN_SEMICOLON
     | name TOKEN_ASSIGN expr TOKEN_SEMICOLON
     ;

type: TOKEN_INT         { $$ = type_create(TYPE_INTEGER, 0, 0); }
    | TOKEN_CHAR        { $$ = type_create(TYEP_CHARACTER, 0, 0); }
    | TOKEN_BOOLEAN     { $$ = type_create(TYPE_BOOLEAN, 0, 0); }
    | TOKEN_STRING      { $$ = type_create(TYPE_STRING, 0, 0); }
    | TOKEN_AUTO        { $$ = type_create(TYPE_AUTO, 0, 0); }
    | TOKEN_VOID        { $$ = type_create(TYPE_VOID, 0, 0); }
    | TOKEN_ARRAY TOKEN_LSQBRAC TOKEN_RSQBRAC type                  { $$ = type_create(TYPE_ARRAY, 0, $4); }
    | TOKEN_ARRAY TOKEN_LSQBRAC TOKEN_NUMBER TOKEN_RSQBRAC type     { $$ = type_create(TYPE_ARRAY, 0, $5); }
    ;

param_list: name TOKEN_COLON type TOKEN_COMMA param_list 
          | name TOKEN_COLON type 
          | func_args
          ;

func_args: expr
         | expr TOKEN_COMMA func_args
         ;

expr: TOKEN_NUMBER
    | TOKEN_TRUE
    | TOKEN_FALSE
    | TOKEN_LBRACE array TOKEN_RBRACE
    | TOKEN_NUMBER a_op TOKEN_NUMBER
    | name a_op name
    | name a_op TOKEN_NUMBER
    | TOKEN_NUMBER a_op name
    | TOKEN_CHARVAL
    | TOKEN_STRVAL
    ;

a_op: TOKEN_ADD
    | TOKEN_MINUS
    | TOKEN_MULT
    | TOKEN_DIV
    | TOKEN_MOD
    | TOKEN_INCREMENT
    | TOKEN_DECREMENT
    | TOKEN_EXPO
    ;

u_expr: TOKEN_NUMBER TOKEN_INCREMENT
      | TOKEN_NUMBER TOKEN_DECREMENT
      | TOKEN_INCREMENT TOKEN_NUMBER
      | TOKEN_DECREMENT TOKEN_NUMBER
      | name TOKEN_INCREMENT
      | name TOKEN_DECREMENT
      | TOKEN_INCREMENT name
      | TOKEN_DECREMENT name
      ;

r_expr: TOKEN_NUMBER r_op TOKEN_NUMBER
      | name r_op name
      | name r_op TOKEN_NUMBER
      | TOKEN_NUMBER r_op name
      | TOKEN_TRUE
      | TOKEN_FALSE
    ;

r_op: TOKEN_NOTEQ
    | TOKEN_GREAT
    | TOKEN_GREATEQ
    | TOKEN_LESS
    | TOKEN_LESSEQ
    | TOKEN_EQUAL
    | TOKEN_LAND
    | TOKEN_LOR
    ;

array: TOKEN_NUMBER
     | TOKEN_NUMBER TOKEN_COMMA array
    ;

name: TOKEN_IDENT
    ;

%%

int yyerror( char *str )
{
	printf("parse error: %s\n",str);
	return 0;
}
