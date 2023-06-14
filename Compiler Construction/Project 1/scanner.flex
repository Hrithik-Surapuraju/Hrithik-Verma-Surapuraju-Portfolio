%{
#include "token.h"
%}
DIGIT  [0-9]
LETTER [a-zA-Z_]
%%
[" "\t\n]+  /* skip whitespace */
 \+         { return TOKEN_ADD; }
 \/\*.*?\*\/   { return TOKEN_CCOMMENT; }
 \/\/.*?        { return TOKEN_CPPCOMMENT; }
 \(         { return TOKEN_LPAREN; }
 \)         { return TOKEN_RPAREN; }
 \[         { return TOKEN_LSQBRAC; }
 \]         { return TOKEN_RSQBRAC; }
 \++        { return TOKEN_INCREMENT;}
 \--        { return TOKEN_DECREMENT; }
 \-         { return TOKEN_MINUS; }
 \!         { return TOKEN_LNOT; }
 \*         { return TOKEN_MULT; }
 \/         { return TOKEN_DIV; }
 \%         { return TOKEN_MOD; }
 \<         { return TOKEN_LESS; }
 \<=        { return TOKEN_LESSEQ; }
 \>         { return TOKEN_GREAT; } 
 \>=        { return TOKEN_GREATEQ; }
 \==        { return TOKEN_EQUAL; }
 \!=        { return TOKEN_NOTEQ; }
 \&\&       { return TOKEN_LAND; }
 \|\|       { return TOKEN_LOR; }
 \=         { return TOKEN_ASSIGN; }
 while      { return TOKEN_WHILE; }
 array      { return TOKEN_ARRAY; }
 auto       { return TOKEN_AUTO; }
 boolean    { return TOKEN_BOOLEAN; }
 char       { return TOKEN_CHAR; }
 else       { return TOKEN_ELSE; }
 false      { return TOKEN_FALSE; }
 for        { return TOKEN_FOR; }
 function   { return TOKEN_FUNCTION; }
 if         { return TOKEN_IF; }
 integer    { return TOKEN_INT; }
 print      { return TOKEN_PRINT; }
 return     { return TOKEN_RETURN; }
 string     { return TOKEN_STRING; }
 true       { return TOKEN_TRUE; }
 void       { return TOKEN_VOID; }
 \:         { return TOKEN_COLON; }
 \;         { return TOKEN_SEMICOLON; }
 \,         { return TOKEN_COMMA; }
 \{         { return TOKEN_LBRACE; }
 \}         { return TOKEN_RBRACE; }
{LETTER}+   { return TOKEN_IDENT; }
{DIGIT}+    { return TOKEN_NUMBER; }
.           { return TOKEN_ERROR; }
%%
int yywrap() { return 1; }
