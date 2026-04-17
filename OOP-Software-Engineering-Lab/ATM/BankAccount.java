package ATM;

public class BankAccount {
    private String accountName;
    private String accountNumber;
    private String password;
    private double balance;
    private static final double MAX_BALANCE = 1_000_000;

    public BankAccount(String accountName, String accountNumber, String password, double balance) {
        if (accountName.length() > 50) {
            throw new IllegalArgumentException("Account name maximum 50 characters.");
        }
        if (accountNumber.length() != 13) {
            throw new IllegalArgumentException("Account number must have 13 digit number.");
        }
        if (password.length() != 4) {
            throw new IllegalArgumentException("Password must have 4 digit number.");
        }
        if (balance < 0 || balance > MAX_BALANCE) {
            throw new IllegalArgumentException("Balance maximum 1,000,000 baht.");
        }
        this.accountName = accountName;
        this.accountNumber = accountNumber;
        this.password = password;
        this.balance = 0.0;
    }

    public String getAccountName() {
        return accountName;
    }

    public String getAccountNumber() {
        return accountNumber;
    }

    public boolean validatePassword(String password) {
        return this.password.equals(password);
    }

    public double getBalance() {
        return balance;
    }
}
