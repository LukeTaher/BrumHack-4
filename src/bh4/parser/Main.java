package bh4;

import bh4.parser.Java8Lexer;
import bh4.parser.Java8Parser;
import org.antlr.v4.runtime.ANTLRFileStream;
import org.antlr.v4.runtime.CommonTokenStream;

import java.io.IOException;

/**
 * Created by samtebbs on 12/03/2016.
 */
public class Main {

    public static void main(String[] args) throws IOException {
        Java8Lexer lexer = new Java8Lexer(new ANTLRFileStream("Test.java"));
        CommonTokenStream stream = new CommonTokenStream(lexer);
        Java8Parser parser = new Java8Parser(stream);
        Java8Parser.CompilationUnitContext compilationUnit = parser.compilationUnit();
    }

}
