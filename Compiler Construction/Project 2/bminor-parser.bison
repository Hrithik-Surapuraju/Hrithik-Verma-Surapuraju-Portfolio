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
%token  TOKEN_IDENT
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

extern char *yytext;
extern int yylex();
extern int yyerror( char *str );

%}

%%

/* Here is the grammar: program is the start symbol. */

program : decl_list 
            { return 0; }
        ;

decl_list : decl 
          | decl decl_list
          | decl TOKEN_CCOMMENT
          | decl TOKEN_CCOMMENT decl_list
          | decl TOKEN_CPPCOMMENT
          | decl TOKEN_CPPCOMMENT decl_list
          ;

decl : TOKEN_CCOMMENT
     | TOKEN_CPPCOMMENT
     | TOKEN_IDENT TOKEN_COLON type TOKEN_SEMICOLON
     | TOKEN_IDENT TOKEN_COLON type TOKEN_ASSIGN expr TOKEN_SEMICOLON 
     | TOKEN_IDENT TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN param_list TOKEN_RPAREN TOKEN_SEMICOLON 
     | TOKEN_IDENT TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN TOKEN_RPAREN TOKEN_SEMICOLON 
     | TOKEN_IDENT TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN param_list TOKEN_RPAREN TOKEN_ASSIGN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | TOKEN_IDENT TOKEN_COLON TOKEN_FUNCTION type TOKEN_LPAREN TOKEN_RPAREN TOKEN_ASSIGN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     ;

stmt_list : stmt stmt_list
          | stmt TOKEN_CCOMMENT
          | stmt TOKEN_CCOMMENT stmt_list
          | stmt TOKEN_CPPCOMMENT
          | stmt TOKEN_CPPCOMMENT stmt_list
          | decl stmt_list 
          | TOKEN_CCOMMENT
          | TOKEN_CPPCOMMENT
          | /* epsilon */	{ $$ = 0; }
          ;

stmt : TOKEN_RETURN expr TOKEN_SEMICOLON
     | TOKEN_IF TOKEN_LPAREN r_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | TOKEN_IF TOKEN_LPAREN r_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE TOKEN_ELSE TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | TOKEN_WHILE TOKEN_LPAREN r_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE
     | TOKEN_FOR TOKEN_LPAREN TOKEN_IDENT TOKEN_ASSIGN expr TOKEN_SEMICOLON r_expr TOKEN_SEMICOLON u_expr TOKEN_RPAREN TOKEN_LBRACE stmt_list TOKEN_RBRACE 
     | TOKEN_IDENT TOKEN_LPAREN func_args TOKEN_RPAREN TOKEN_SEMICOLON
     | TOKEN_IDENT TOKEN_ASSIGN expr TOKEN_SEMICOLON
     ;

type: TOKEN_INT 
    | TOKEN_CHAR 
    | TOKEN_BOOLEAN 
    | TOKEN_STRING 
    | TOKEN_AUTO 
    | TOKEN_VOID 
    | TOKEN_ARRAY TOKEN_LSQBRAC TOKEN_RSQBRAC type 
    | TOKEN_ARRAY TOKEN_LSQBRAC TOKEN_NUMBER TOKEN_RSQBRAC type 
    ;

param_list: TOKEN_IDENT TOKEN_COLON type TOKEN_COMMA param_list 
          | TOKEN_IDENT TOKEN_COLON type 
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
    | TOKEN_IDENT a_op TOKEN_IDENT
    | TOKEN_IDENT a_op TOKEN_NUMBER
    | TOKEN_NUMBER a_op TOKEN_IDENT
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
      | TOKEN_IDENT TOKEN_INCREMENT
      | TOKEN_IDENT TOKEN_DECREMENT
      | TOKEN_INCREMENT TOKEN_IDENT
      | TOKEN_DECREMENT TOKEN_IDENT
      ;

r_expr: TOKEN_NUMBER r_op TOKEN_NUMBER
      | TOKEN_IDENT r_op TOKEN_IDENT
      | TOKEN_IDENT r_op TOKEN_NUMBER
      | TOKEN_NUMBER r_op TOKEN_IDENT
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
%%

int yyerror( char *str )
{
	printf("parse error: %s\n",str);
	return 0;
}
