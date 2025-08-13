# Praticas de Organização de codigo:

  exemplo

antes:
if ($idade>=18){
return 1;
} else {
return 0;
}

depois
if($idade>=18){
return true;
}
return false;

Principais motivos do codigo ter um padrão e boas praticas de programação:

Codigo mal escrtio sem otimização leva mais tempo de indendiemento, 
Custa mais tempo e consequentemente mais dinheiro para ser atualizado.

Conceitos da aula:
Boas praticas de programação:
o simples bem feito tras mais resultados.

Custo de ma qualidade de codigo
exemplo: custo, quebra servidor, codigo sem estrutura.

Legibilidade vs Performance:
Legibilidade: Codigo com principio de ser bem estruturado
Perfomance: codigo com principio de rodar primeiro

Principios funcamentais

DRY - Dont repeat yourself (nao repita mesma coisa, codigo que possui muita repetição da mesma função, mais facil ter apenas uma fonte e ser chamado varias vezes)
KISS - Keep is simple, stupid (o simples funciona melhor do que encher linguiça, mantenha o codigo simples, para ser acessivel)
YAGNI - You arent gonna need it (esse codigo vai precisar to toda a estrutura que está sendo criado)



cenario comum
Startup desenvolve MVP em 2 meses
(codigo funcional mas sem todas as soluções e sem o codigo dinamico, isso pode atrasar em processos futuros por nao ter documentação corretas)

termos na aula: 
definição do tipo de entrada e saida da função, variavel, é o assinatura da função
debug: teste e validação de codigo
codigo magico: parte do codigo que não identifica a raiz e o motivo de estar lá mas funciona


&Simulação Codigo rapido mal feito vs limpo mais tempo





